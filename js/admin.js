(function () {
    'use strict';

    const config = window.ADMIN_CONFIG || {};
    const apiUrl = config.apiUrl;

    if (!apiUrl) {
        return;
    }

    const backdrop = document.getElementById('admin-modal-backdrop');
    const modal = document.getElementById('admin-modal');
    const form = document.getElementById('admin-product-form');
    const errorEl = document.getElementById('admin-form-error');
    const successEl = document.getElementById('admin-form-success');
    const deleteBtn = document.getElementById('admin-delete-btn');
    const imagenInput = document.getElementById('admin-imagen-archivo');
    const imagenUrlInput = document.getElementById('admin-imagen');
    const imagenPreview = document.getElementById('admin-imagen-preview');
    let categoriasCache = [];
    let previewObjectUrl = null;

    function resolveImageSrc(path) {
        if (!path) {
            return '';
        }

        if (/^https?:\/\//i.test(path) || path.startsWith('//')) {
            return path;
        }

        return `${config.uploadsBasePath || ''}${path.replace(/^\//, '')}`;
    }

    function clearPreviewObjectUrl() {
        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
            previewObjectUrl = null;
        }
    }

    function updateImagePreview(path) {
        if (!imagenPreview) {
            return;
        }

        clearPreviewObjectUrl();

        if (!path) {
            imagenPreview.src = '';
            imagenPreview.classList.add('hidden');
            return;
        }

        imagenPreview.src = resolveImageSrc(path);
        imagenPreview.classList.remove('hidden');
    }

    function openModal() {
        backdrop?.classList.remove('hidden');
        modal?.classList.remove('hidden');
        modal?.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        backdrop?.classList.add('hidden');
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        hideMessages();
        clearPreviewObjectUrl();
        imagenInput && (imagenInput.value = '');
    }

    function hideMessages() {
        errorEl?.classList.add('hidden');
        successEl?.classList.add('hidden');
    }

    function showError(message) {
        if (!errorEl) return;
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
        successEl?.classList.add('hidden');
    }

    function fillCategorias(categorias, selectedId) {
        const select = document.getElementById('admin-categoria');
        if (!select) return;

        select.innerHTML = '';
        categorias.forEach((cat) => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.nombre;
            if (Number(cat.id) === Number(selectedId)) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    }

    function populateForm(producto, categorias) {
        document.getElementById('admin-id').value = producto?.id || '';
        document.getElementById('admin-action').value = producto?.id ? 'update' : 'create';
        document.getElementById('admin-modal-title').textContent = producto?.id ? 'Editar producto' : 'Nuevo producto';
        document.getElementById('admin-nombre').value = producto?.nombre || '';
        document.getElementById('admin-precio').value = producto?.precio || '';
        document.getElementById('admin-imagen').value = producto?.imagen_principal || '';
        imagenInput && (imagenInput.value = '');
        updateImagePreview(producto?.imagen_principal || '');
        document.getElementById('admin-descripcion').value = producto?.descripcion || '';
        document.getElementById('admin-lavado').value = producto?.lavado || '';
        document.getElementById('admin-fit').value = producto?.fit || '';
        document.getElementById('admin-material').value = producto?.material_info || '';
        document.getElementById('admin-stock').value = producto?.stock_estado || 'disponible';
        document.getElementById('admin-tallas').value = (producto?.tallas || []).join(', ');
        document.getElementById('admin-activo').checked = producto?.id
            ? Number(producto.activo) === 1
            : true;

        fillCategorias(categorias, producto?.categoria_id || categorias[0]?.id);

        if (deleteBtn) {
            deleteBtn.classList.toggle('hidden', !producto?.id);
        }
    }

    async function fetchJson(url, options = {}) {
        const response = await fetch(url, { credentials: 'same-origin', ...options });
        return response.json();
    }

    async function openEditModal(productId) {
        hideMessages();

        try {
            const data = await fetchJson(`${apiUrl}?action=get&id=${productId}`);

            if (!data.ok) {
                openModal();
                showError(data.error || 'No se pudo cargar el producto.');
                return;
            }

            categoriasCache = data.categorias || [];
            populateForm(data.producto, categoriasCache);
            openModal();
        } catch {
            openModal();
            showError('Error de conexión al cargar el producto.');
        }
    }

    async function openCreateModal() {
        hideMessages();

        try {
            let categorias = categoriasCache;

            if (!categorias.length) {
                const data = await fetchJson(`${apiUrl}?action=categorias`);
                categorias = data.categorias || [];
                categoriasCache = categorias;
            }

            populateForm({ categoria_id: config.defaultCategoriaId || categorias[0]?.id }, categorias);
            openModal();
        } catch {
            showError('Error al preparar el formulario.');
        }
    }

    imagenInput?.addEventListener('change', () => {
        const file = imagenInput.files?.[0];

        if (!file) {
            updateImagePreview(imagenUrlInput?.value || '');
            return;
        }

        clearPreviewObjectUrl();
        previewObjectUrl = URL.createObjectURL(file);
        imagenPreview.src = previewObjectUrl;
        imagenPreview.classList.remove('hidden');
    });

    imagenUrlInput?.addEventListener('input', () => {
        if (imagenInput?.files?.length) {
            return;
        }

        updateImagePreview(imagenUrlInput.value.trim());
    });

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        hideMessages();

        const productId = document.getElementById('admin-id').value;
        const hasFile = Boolean(imagenInput?.files?.length);
        const hasUrl = Boolean(imagenUrlInput?.value.trim());
        const isCreate = document.getElementById('admin-action').value === 'create';

        if (isCreate && !hasFile && !hasUrl) {
            showError('Sube una imagen o indica una URL.');
            return;
        }

        const formData = new FormData(form);
        const action = document.getElementById('admin-action').value;
        formData.set('action', action);

        if (document.getElementById('admin-activo').checked) {
            formData.set('activo', '1');
        } else {
            formData.delete('activo');
        }

        try {
            const data = await fetchJson(apiUrl, {
                method: 'POST',
                body: formData,
            });

            if (!data.ok) {
                showError(data.error || 'No se pudo guardar.');
                return;
            }

            if (successEl) {
                successEl.textContent = data.message;
                successEl.classList.remove('hidden');
            }

            setTimeout(() => window.location.reload(), 700);
        } catch {
            showError('Error de conexión al guardar.');
        }
    });

    deleteBtn?.addEventListener('click', async () => {
        const id = document.getElementById('admin-id').value;

        if (!id || !confirm('¿Ocultar este producto de la tienda?')) {
            return;
        }

        const formData = new FormData();
        formData.set('action', 'delete');
        formData.set('id', id);

        try {
            const data = await fetchJson(apiUrl, { method: 'POST', body: formData });

            if (!data.ok) {
                showError(data.error || 'No se pudo ocultar el producto.');
                return;
            }

            window.location.reload();
        } catch {
            showError('Error de conexión.');
        }
    });

    document.getElementById('admin-new-product')?.addEventListener('click', openCreateModal);
    document.getElementById('admin-modal-close')?.addEventListener('click', closeModal);
    document.getElementById('admin-cancel-btn')?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);

    document.addEventListener('click', (event) => {
        const editBtn = event.target.closest('[data-admin-edit]');

        if (editBtn) {
            event.preventDefault();
            event.stopPropagation();
            openEditModal(editBtn.dataset.adminEdit);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
})();
