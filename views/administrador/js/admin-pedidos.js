(function () {
    'use strict';

    const config = window.PEDIDOS_CONFIG || {};
    const apiUrl = config.apiUrl;

    if (!apiUrl) {
        return;
    }

    const loadingEl = document.getElementById('pedidos-loading');
    const emptyEl = document.getElementById('pedidos-empty');
    const errorEl = document.getElementById('pedidos-error');
    const tableWrap = document.getElementById('pedidos-table-wrap');
    const tbody = document.getElementById('pedidos-tbody');
    const filtroEstado = document.getElementById('filtro-estado');
    const btnRefrescar = document.getElementById('btn-refrescar-pedidos');
    const paginationEl = document.getElementById('pedidos-pagination');
    const infoEl = document.getElementById('pedidos-info');
    const btnAnterior = document.getElementById('btn-pagina-anterior');
    const btnSiguiente = document.getElementById('btn-pagina-siguiente');

    const modalBackdrop = document.getElementById('pedido-detalle-backdrop');
    const modal = document.getElementById('pedido-detalle-modal');
    const modalContenido = document.getElementById('pedido-detalle-contenido');
    const modalCerrar = document.getElementById('pedido-detalle-cerrar');
    const estadoSelect = document.getElementById('pedido-estado-select');
    const btnGuardarEstado = document.getElementById('pedido-guardar-estado');
    const detalleMensaje = document.getElementById('pedido-detalle-mensaje');

    let paginaActual = 1;
    let totalPaginas = 1;
    let pedidoActualId = null;

    function formatearPrecio(valor) {
        const numero = Number(valor) || 0;
        return '$' + numero.toLocaleString('es-CO', { maximumFractionDigits: 0 });
    }

    function formatearFecha(fechaStr) {
        if (!fechaStr) {
            return '—';
        }

        const fecha = new Date(fechaStr.replace(' ', 'T'));

        if (Number.isNaN(fecha.getTime())) {
            return fechaStr;
        }

        return fecha.toLocaleString('es-CO', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    }

    function etiquetaEstado(estado) {
        const mapa = {
            pendiente: 'Pendiente',
            confirmado: 'Confirmado',
            enviado: 'Enviado',
            cancelado: 'Cancelado',
        };

        return mapa[estado] || estado;
    }

    function mostrarCargando() {
        loadingEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');
        errorEl.classList.add('hidden');
        tableWrap.classList.add('hidden');
        paginationEl.classList.add('hidden');
    }

    async function cargarPedidos() {
        mostrarCargando();

        const estado = filtroEstado.value;
        const params = new URLSearchParams({
            action: 'list',
            page: String(paginaActual),
            limit: '20',
        });

        if (estado) {
            params.set('estado', estado);
        }

        try {
            const respuesta = await fetch(`${apiUrl}?${params.toString()}`);
            const data = await respuesta.json();

            loadingEl.classList.add('hidden');

            if (!data.ok) {
                errorEl.textContent = data.error || 'No se pudieron cargar los pedidos.';
                errorEl.classList.remove('hidden');
                return;
            }

            const pedidos = data.pedidos || [];
            totalPaginas = data.totalPages || 1;

            if (pedidos.length === 0) {
                emptyEl.classList.remove('hidden');
                return;
            }

            tbody.innerHTML = pedidos.map((pedido) => `
                <tr data-pedido-id="${pedido.id}">
                    <td class="font-mono">#${pedido.id}</td>
                    <td>${formatearFecha(pedido.fecha_creacion)}</td>
                    <td>${escapeHtml(pedido.nombre)} ${escapeHtml(pedido.apellido)}</td>
                    <td>${escapeHtml(pedido.email)}</td>
                    <td class="font-mono">${formatearPrecio(pedido.total)}</td>
                    <td><span class="pedido-estado pedido-estado--${pedido.estado}">${etiquetaEstado(pedido.estado)}</span></td>
                    <td><span class="material-symbols-outlined text-on-surface-variant text-base">chevron_right</span></td>
                </tr>
            `).join('');

            tableWrap.classList.remove('hidden');
            paginationEl.classList.remove('hidden');

            const inicio = (data.page - 1) * data.limit + 1;
            const fin = Math.min(data.page * data.limit, data.total);
            infoEl.textContent = `Mostrando ${inicio}–${fin} de ${data.total} pedidos`;

            btnAnterior.disabled = data.page <= 1;
            btnSiguiente.disabled = data.page >= totalPaginas;
        } catch (err) {
            loadingEl.classList.add('hidden');
            errorEl.textContent = 'Error de conexión al cargar pedidos.';
            errorEl.classList.remove('hidden');
        }
    }

    function escapeHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto ?? '';
        return div.innerHTML;
    }

    function abrirModal() {
        modalBackdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModal() {
        modalBackdrop.classList.add('hidden');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        pedidoActualId = null;
        detalleMensaje.classList.add('hidden');
    }

    async function verDetalle(pedidoId) {
        pedidoActualId = pedidoId;
        modalContenido.innerHTML = '<p class="text-on-surface-variant font-body-md">Cargando…</p>';
        abrirModal();

        try {
            const respuesta = await fetch(`${apiUrl}?action=get&id=${pedidoId}`);
            const data = await respuesta.json();

            if (!data.ok || !data.pedido) {
                modalContenido.innerHTML = '<p class="text-error font-body-md">No se pudo cargar el pedido.</p>';
                return;
            }

            const pedido = data.pedido;
            document.getElementById('pedido-detalle-titulo').textContent = `Pedido #${pedido.id}`;
            estadoSelect.value = pedido.estado;

            const itemsHtml = (pedido.items || []).map((item) => {
                const subtotal = (Number(item.precio) || 0) * (Number(item.cantidad) || 1);
                const imagenHtml = item.imagen
                    ? `<img src="${escapeHtml(item.imagen)}" alt="${escapeHtml(item.nombre)}" class="pedido-item-img" loading="lazy" />`
                    : '<span class="pedido-item-sin-img material-symbols-outlined">image_not_supported</span>';

                return `
                    <tr>
                        <td class="pedido-item-celda-img">${imagenHtml}</td>
                        <td>${escapeHtml(item.nombre)}</td>
                        <td>${escapeHtml(item.talla || '—')}</td>
                        <td>${item.cantidad}</td>
                        <td>${formatearPrecio(item.precio)}</td>
                        <td>${formatearPrecio(subtotal)}</td>
                    </tr>
                `;
            }).join('');

            const notasHtml = pedido.notas
                ? `<p class="font-body-md mt-2"><strong>Notas:</strong> ${escapeHtml(pedido.notas)}</p>`
                : '';

            modalContenido.innerHTML = `
                <div class="pedido-detalle-grid">
                    <div class="pedido-detalle-seccion">
                        <h3>Cliente</h3>
                        <p class="font-body-md">${escapeHtml(pedido.nombre)} ${escapeHtml(pedido.apellido)}</p>
                        <p class="font-body-md text-on-surface-variant">${escapeHtml(pedido.email)}</p>
                        <p class="font-body-md text-on-surface-variant">${escapeHtml(pedido.telefono)}</p>
                    </div>
                    <div class="pedido-detalle-seccion">
                        <h3>Envío</h3>
                        <p class="font-body-md">${escapeHtml(pedido.direccion)}</p>
                        <p class="font-body-md text-on-surface-variant">${escapeHtml(pedido.codigo_postal)} ${escapeHtml(pedido.ciudad)}, ${escapeHtml(pedido.provincia)}</p>
                        ${notasHtml}
                    </div>
                </div>

                <div class="pedido-detalle-seccion">
                    <h3>Productos (${(pedido.items || []).length})</h3>
                    <div class="overflow-x-auto">
                        <table class="pedido-items-table">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>${itemsHtml}</tbody>
                        </table>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1 pt-4 border-t border-outline-variant">
                    <p class="font-body-md">Subtotal: <strong>${formatearPrecio(pedido.subtotal)}</strong></p>
                    <p class="font-body-md">Envío: <strong>${formatearPrecio(pedido.envio)}</strong></p>
                    <p class="font-headline-sm text-headline-sm text-primary">Total: ${formatearPrecio(pedido.total)}</p>
                    <p class="font-body-sm text-on-surface-variant mt-2">Fecha: ${formatearFecha(pedido.fecha_creacion)}</p>
                </div>
            `;
        } catch (err) {
            modalContenido.innerHTML = '<p class="text-error font-body-md">Error de conexión.</p>';
        }
    }

    async function guardarEstado() {
        if (!pedidoActualId) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'update_estado');
        formData.append('id', String(pedidoActualId));
        formData.append('estado', estadoSelect.value);

        btnGuardarEstado.disabled = true;

        try {
            const respuesta = await fetch(apiUrl, { method: 'POST', body: formData });
            const data = await respuesta.json();

            detalleMensaje.textContent = data.message || (data.ok ? 'Estado actualizado.' : (data.error || 'Error al guardar.'));
            detalleMensaje.classList.remove('hidden');
            detalleMensaje.classList.toggle('text-secondary', data.ok);
            detalleMensaje.classList.toggle('text-error', !data.ok);

            if (data.ok) {
                cargarPedidos();
            }
        } catch (err) {
            detalleMensaje.textContent = 'Error de conexión.';
            detalleMensaje.classList.remove('hidden');
            detalleMensaje.classList.add('text-error');
        } finally {
            btnGuardarEstado.disabled = false;
        }
    }

    tbody.addEventListener('click', (event) => {
        const fila = event.target.closest('tr[data-pedido-id]');

        if (!fila) {
            return;
        }

        verDetalle(fila.dataset.pedidoId);
    });

    filtroEstado.addEventListener('change', () => {
        paginaActual = 1;
        cargarPedidos();
    });

    btnRefrescar.addEventListener('click', cargarPedidos);

    btnAnterior.addEventListener('click', () => {
        if (paginaActual > 1) {
            paginaActual -= 1;
            cargarPedidos();
        }
    });

    btnSiguiente.addEventListener('click', () => {
        if (paginaActual < totalPaginas) {
            paginaActual += 1;
            cargarPedidos();
        }
    });

    modalCerrar.addEventListener('click', cerrarModal);
    modalBackdrop.addEventListener('click', cerrarModal);
    btnGuardarEstado.addEventListener('click', guardarEstado);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModal();
        }
    });

    cargarPedidos();
})();
