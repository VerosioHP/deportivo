(function () {
    'use strict';

    const config = window.USUARIOS_CONFIG || {};
    const apiUrl = config.apiUrl;
    const sesionUsuarioId = Number(config.sesionUsuarioId) || 0;

    if (!apiUrl) {
        return;
    }

    const loadingEl = document.getElementById('usuarios-loading');
    const emptyEl = document.getElementById('usuarios-empty');
    const errorEl = document.getElementById('usuarios-error');
    const tableWrap = document.getElementById('usuarios-table-wrap');
    const tbody = document.getElementById('usuarios-tbody');
    const btnNuevo = document.getElementById('btn-nuevo-usuario');

    const modalBackdrop = document.getElementById('usuario-modal-backdrop');
    const modal = document.getElementById('usuario-modal');
    const form = document.getElementById('usuario-form');
    const modalTitulo = document.getElementById('usuario-modal-titulo');
    const inputId = document.getElementById('usuario-id');
    const inputAction = document.getElementById('usuario-action');
    const inputNombre = document.getElementById('usuario-nombre');
    const inputApellido = document.getElementById('usuario-apellido');
    const inputEmail = document.getElementById('usuario-email');
    const inputPassword = document.getElementById('usuario-password');
    const inputRol = document.getElementById('usuario-rol');
    const passwordHint = document.getElementById('usuario-password-hint');
    const passwordAyuda = document.getElementById('usuario-password-ayuda');
    const formError = document.getElementById('usuario-form-error');
    const btnEliminar = document.getElementById('usuario-eliminar');
    const btnCerrar = document.getElementById('usuario-modal-cerrar');
    const btnCancelar = document.getElementById('usuario-cancelar');

    function escapeHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto ?? '';
        return div.innerHTML;
    }

    function nombreCompleto(usuario) {
        return [usuario.nombre, usuario.apellido].filter(Boolean).join(' ').trim() || '—';
    }

    function formatearFecha(fecha) {
        if (!fecha) {
            return '—';
        }

        const date = new Date(fecha.replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return fecha;
        }

        return date.toLocaleDateString('es-CO', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        });
    }

    function etiquetaRol(rol) {
        return rol === 'admin'
            ? '<span class="usuario-rol usuario-rol--admin">Admin</span>'
            : '<span class="usuario-rol usuario-rol--cliente">Cliente</span>';
    }

    function mostrarCargando() {
        loadingEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');
        errorEl.classList.add('hidden');
        tableWrap.classList.add('hidden');
    }

    function configurarModoPassword(esEdicion) {
        if (esEdicion) {
            inputPassword.required = false;
            inputPassword.value = '';
            passwordHint.textContent = '';
            passwordAyuda.classList.remove('hidden');
        } else {
            inputPassword.required = true;
            passwordHint.textContent = '*';
            passwordAyuda.classList.add('hidden');
        }
    }

    async function cargarUsuarios() {
        mostrarCargando();

        try {
            const respuesta = await fetch(`${apiUrl}?action=list`);
            const data = await respuesta.json();

            loadingEl.classList.add('hidden');

            if (!data.ok) {
                errorEl.textContent = data.error || 'No se pudieron cargar los usuarios.';
                errorEl.classList.remove('hidden');
                return;
            }

            const usuarios = data.usuarios || [];

            if (usuarios.length === 0) {
                emptyEl.classList.remove('hidden');
                return;
            }

            tbody.innerHTML = usuarios.map((usuario) => `
                <tr data-usuario-id="${usuario.id}">
                    <td class="font-label-md">${escapeHtml(nombreCompleto(usuario))}</td>
                    <td class="usuario-email">${escapeHtml(usuario.email)}</td>
                    <td>${etiquetaRol(usuario.rol)}</td>
                    <td class="usuario-fecha">${escapeHtml(formatearFecha(usuario.fecha_creacion))}</td>
                    <td><span class="material-symbols-outlined text-on-surface-variant text-base">edit</span></td>
                </tr>
            `).join('');

            tableWrap.classList.remove('hidden');
        } catch (err) {
            loadingEl.classList.add('hidden');
            errorEl.textContent = 'Error de conexión al cargar usuarios.';
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
        btnEliminar.classList.add('hidden');
        configurarModoPassword(false);
    }

    function abrirCrear() {
        inputId.value = '';
        inputAction.value = 'create';
        modalTitulo.textContent = 'Nuevo usuario';
        btnEliminar.classList.add('hidden');
        formError.classList.add('hidden');
        inputRol.value = 'cliente';
        configurarModoPassword(false);
        abrirModal();
        inputNombre.focus();
    }

    async function abrirEditar(usuarioId) {
        formError.classList.add('hidden');

        try {
            const respuesta = await fetch(`${apiUrl}?action=get&id=${usuarioId}`);
            const data = await respuesta.json();

            if (!data.ok || !data.usuario) {
                formError.textContent = data.error || 'No se pudo cargar el usuario.';
                formError.classList.remove('hidden');
                abrirModal();
                return;
            }

            const usuario = data.usuario;
            inputId.value = usuario.id;
            inputAction.value = 'update';
            inputNombre.value = usuario.nombre || '';
            inputApellido.value = usuario.apellido || '';
            inputEmail.value = usuario.email || '';
            inputRol.value = usuario.rol || 'cliente';
            modalTitulo.textContent = 'Editar usuario';
            btnEliminar.classList.toggle('hidden', Number(usuario.id) === sesionUsuarioId);
            configurarModoPassword(true);
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

        if (inputAction.value === 'update' && !inputPassword.value.trim()) {
            formData.delete('password');
        }

        try {
            const respuesta = await fetch(apiUrl, { method: 'POST', body: formData });
            const data = await respuesta.json();

            if (!data.ok) {
                formError.textContent = data.error || 'No se pudo guardar.';
                formError.classList.remove('hidden');
                return;
            }

            cerrarModal();
            cargarUsuarios();
        } catch (err) {
            formError.textContent = 'Error de conexión.';
            formError.classList.remove('hidden');
        }
    });

    btnEliminar.addEventListener('click', async () => {
        const id = inputId.value;

        if (!id || !confirm('¿Eliminar este usuario? Esta acción no se puede deshacer.')) {
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
            cargarUsuarios();
        } catch (err) {
            formError.textContent = 'Error de conexión.';
            formError.classList.remove('hidden');
        }
    });

    tbody.addEventListener('click', (event) => {
        const fila = event.target.closest('tr[data-usuario-id]');

        if (!fila) {
            return;
        }

        abrirEditar(fila.dataset.usuarioId);
    });

    btnNuevo.addEventListener('click', abrirCrear);
    btnCerrar.addEventListener('click', cerrarModal);
    btnCancelar.addEventListener('click', cerrarModal);
    modalBackdrop.addEventListener('click', cerrarModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModal();
        }
    });

    cargarUsuarios();
})();
