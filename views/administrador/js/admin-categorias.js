(function () {
    'use strict';

    const config = window.CATEGORIAS_CONFIG || {};
    const apiUrl = config.apiUrl;

    if (!apiUrl) {
        return;
    }

    const loadingEl = document.getElementById('categorias-loading');
    const emptyEl = document.getElementById('categorias-empty');
    const errorEl = document.getElementById('categorias-error');
    const tableWrap = document.getElementById('categorias-table-wrap');
    const tbody = document.getElementById('categorias-tbody');
    const btnNueva = document.getElementById('btn-nueva-categoria');

    const modalBackdrop = document.getElementById('categoria-modal-backdrop');
    const modal = document.getElementById('categoria-modal');
    const form = document.getElementById('categoria-form');
    const modalTitulo = document.getElementById('categoria-modal-titulo');
    const inputId = document.getElementById('categoria-id');
    const inputAction = document.getElementById('categoria-action');
    const inputNombre = document.getElementById('categoria-nombre');
    const inputDescripcion = document.getElementById('categoria-descripcion');
    const slugPreview = document.getElementById('categoria-slug-preview');
    const formError = document.getElementById('categoria-form-error');
    const btnEliminar = document.getElementById('categoria-eliminar');
    const btnCerrar = document.getElementById('categoria-modal-cerrar');
    const btnCancelar = document.getElementById('categoria-cancelar');

    function escapeHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto ?? '';
        return div.innerHTML;
    }

    function generarSlugPreview(nombre) {
        const slug = nombre
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/gi, '-')
            .replace(/^-+|-+$/g, '');

        return slug || 'categoria';
    }

    function actualizarSlugPreview() {
        const nombre = inputNombre.value.trim();

        if (!nombre) {
            slugPreview.classList.add('hidden');
            return;
        }

        slugPreview.textContent = `URL del catálogo: catalogo.php?categoria=${generarSlugPreview(nombre)}`;
        slugPreview.classList.remove('hidden');
    }

    function mostrarCargando() {
        loadingEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');
        errorEl.classList.add('hidden');
        tableWrap.classList.add('hidden');
    }

    async function cargarCategorias() {
        mostrarCargando();

        try {
            const respuesta = await fetch(`${apiUrl}?action=list`);
            const data = await respuesta.json();

            loadingEl.classList.add('hidden');

            if (!data.ok) {
                errorEl.textContent = data.error || 'No se pudieron cargar las categorías.';
                errorEl.classList.remove('hidden');
                return;
            }

            const categorias = data.categorias || [];

            if (categorias.length === 0) {
                emptyEl.classList.remove('hidden');
                return;
            }

            tbody.innerHTML = categorias.map((cat) => `
                <tr data-categoria-id="${cat.id}">
                    <td class="font-label-md">${escapeHtml(cat.nombre)}</td>
                    <td><span class="categoria-slug">${escapeHtml(cat.slug)}</span></td>
                    <td class="categoria-desc">${escapeHtml(cat.descripcion || '—')}</td>
                    <td>${Number(cat.productos_count) || 0}</td>
                    <td><span class="material-symbols-outlined text-on-surface-variant text-base">edit</span></td>
                </tr>
            `).join('');

            tableWrap.classList.remove('hidden');
        } catch (err) {
            loadingEl.classList.add('hidden');
            errorEl.textContent = 'Error de conexión al cargar categorías.';
            errorEl.classList.remove('hidden');
        }
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
        form.reset();
        formError.classList.add('hidden');
        slugPreview.classList.add('hidden');
        btnEliminar.classList.add('hidden');
    }

    function abrirCrear() {
        inputId.value = '';
        inputAction.value = 'create';
        modalTitulo.textContent = 'Nueva categoría';
        btnEliminar.classList.add('hidden');
        formError.classList.add('hidden');
        slugPreview.classList.add('hidden');
        abrirModal();
        inputNombre.focus();
    }

    async function abrirEditar(categoriaId) {
        formError.classList.add('hidden');

        try {
            const respuesta = await fetch(`${apiUrl}?action=get&id=${categoriaId}`);
            const data = await respuesta.json();

            if (!data.ok || !data.categoria) {
                formError.textContent = data.error || 'No se pudo cargar la categoría.';
                formError.classList.remove('hidden');
                abrirModal();
                return;
            }

            const cat = data.categoria;
            inputId.value = cat.id;
            inputAction.value = 'update';
            inputNombre.value = cat.nombre || '';
            inputDescripcion.value = cat.descripcion || '';
            modalTitulo.textContent = 'Editar categoría';
            btnEliminar.classList.toggle('hidden', false);
            actualizarSlugPreview();
            abrirModal();
        } catch (err) {
            formError.textContent = 'Error de conexión.';
            formError.classList.remove('hidden');
            abrirModal();
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        formError.classList.add('hidden');

        const formData = new FormData(form);
        formData.set('action', inputAction.value);

        try {
            const respuesta = await fetch(apiUrl, { method: 'POST', body: formData });
            const data = await respuesta.json();

            if (!data.ok) {
                formError.textContent = data.error || 'No se pudo guardar.';
                formError.classList.remove('hidden');
                return;
            }

            cerrarModal();
            cargarCategorias();
        } catch (err) {
            formError.textContent = 'Error de conexión.';
            formError.classList.remove('hidden');
        }
    });

    btnEliminar.addEventListener('click', async () => {
        const id = inputId.value;

        if (!id || !confirm('¿Eliminar esta categoría? Solo es posible si no tiene productos.')) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        try {
            const respuesta = await fetch(apiUrl, { method: 'POST', body: formData });
            const data = await respuesta.json();

            if (!data.ok) {
                formError.textContent = data.error || 'No se pudo eliminar.';
                formError.classList.remove('hidden');
                return;
            }

            cerrarModal();
            cargarCategorias();
        } catch (err) {
            formError.textContent = 'Error de conexión.';
            formError.classList.remove('hidden');
        }
    });

    tbody.addEventListener('click', (event) => {
        const fila = event.target.closest('tr[data-categoria-id]');

        if (!fila) {
            return;
        }

        abrirEditar(fila.dataset.categoriaId);
    });

    inputNombre.addEventListener('input', actualizarSlugPreview);

    btnNueva.addEventListener('click', abrirCrear);
    btnCerrar.addEventListener('click', cerrarModal);
    btnCancelar.addEventListener('click', cerrarModal);
    modalBackdrop.addEventListener('click', cerrarModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModal();
        }
    });

    cargarCategorias();
})();
