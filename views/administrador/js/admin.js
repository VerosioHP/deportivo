(function () {
    'use strict';

    const config = window.ADMIN_CONFIG || {};
    const apiUrl = config.apiUrl;
    if (!apiUrl) return;

    const backdrop = document.getElementById('admin-modal-backdrop');
    const modal = document.getElementById('admin-modal');
    const form = document.getElementById('admin-product-form');
    const errorEl = document.getElementById('admin-form-error');
    const successEl = document.getElementById('admin-form-success');
    const deleteBtn = document.getElementById('admin-delete-btn');
    const imagenInput = document.getElementById('admin-imagen-archivo');
    const imagenUrlInput = document.getElementById('admin-imagen');
    const imagenActualInput = document.getElementById('admin-imagen-actual');
    const imagenPreview = document.getElementById('admin-imagen-preview');
    const galeriaInput = document.getElementById('admin-galeria-archivos');
    const galeriaExistente = document.getElementById('admin-galeria-existente');
    const galeriaNuevas = document.getElementById('admin-galeria-nuevas');
    const galeriaEliminar = document.getElementById('admin-galeria-eliminar');
    let categoriasCache = [];
    let previewObjectUrl = null;
    const galeriaPreviewUrls = [];
    let galeriaEliminarIds = [];
    let galeriaFilesPendientes = [];

    function resolveImageSrc(path) {
        if (!path) return '';
        if (/^https?:\/\//i.test(path) || path.startsWith('//')) return path;
        if (path.startsWith('/')) return path;
        return `${config.uploadsBasePath || ''}${path.replace(/^\//, '')}`;
    }

    function isExternalImage(path) {
        return /^https?:\/\//i.test(path || '') || String(path || '').startsWith('//');
    }

    function escapeAttr(v) {
        return String(v).replace(/&/g, '&amp;').replace(/"/g, '&quot;');
    }

    function clearGaleriaPreviews() {
        while (galeriaPreviewUrls.length) {
            URL.revokeObjectURL(galeriaPreviewUrls.pop());
        }
        if (galeriaNuevas) galeriaNuevas.innerHTML = '';
        if (galeriaInput) galeriaInput.value = '';
        galeriaFilesPendientes = [];
        syncGaleriaInputFiles();
    }

    function syncGaleriaInputFiles() {
        if (!galeriaInput || typeof DataTransfer === 'undefined') return;
        const dt = new DataTransfer();
        galeriaFilesPendientes.forEach((file) => dt.items.add(file));
        galeriaInput.files = dt.files;
    }

    function renderGaleriaEliminarInputs() {
        if (!galeriaEliminar) return;
        galeriaEliminar.innerHTML = galeriaEliminarIds
            .map((id) => `<input type="hidden" name="galeria_eliminar[]" value="${escapeAttr(id)}" />`)
            .join('');
    }

    function renderGaleriaExistente(imagenes) {
        if (!galeriaExistente) return;
        galeriaExistente.innerHTML = '';
        galeriaEliminarIds = [];
        renderGaleriaEliminarInputs();

        (imagenes || []).forEach((img) => {
            const id = Number(img.id || 0);
            if (id <= 0) return;

            const item = document.createElement('div');
            item.className = 'admin-galeria-item relative';
            item.dataset.imagenId = String(id);
            item.innerHTML = `
                <img src="${escapeAttr(resolveImageSrc(img.url))}" alt="Toma del producto" class="w-16 aspect-[3/4] object-cover border border-outline-variant bg-surface-container" />
                <button type="button" class="admin-galeria-remove absolute top-1 right-1 bg-surface/90 text-error text-xs px-1.5 py-0.5 uppercase tracking-widest" title="Quitar">×</button>
            `;
            item.querySelector('.admin-galeria-remove')?.addEventListener('click', () => {
                galeriaEliminarIds.push(id);
                renderGaleriaEliminarInputs();
                item.remove();
            });
            galeriaExistente.appendChild(item);
        });
    }

    function renderGaleriaNuevasPreview() {
        while (galeriaPreviewUrls.length) {
            URL.revokeObjectURL(galeriaPreviewUrls.pop());
        }
        if (!galeriaNuevas) return;
        galeriaNuevas.innerHTML = '';

        galeriaFilesPendientes.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            galeriaPreviewUrls.push(url);
            const item = document.createElement('div');
            item.className = 'admin-galeria-item relative';
            item.innerHTML = `
                <img src="${escapeAttr(url)}" alt="Nueva toma" class="w-16 aspect-[3/4] object-cover border border-secondary bg-surface-container" />
                <button type="button" class="admin-galeria-remove absolute top-1 right-1 bg-surface/90 text-error text-xs px-1.5 py-0.5 uppercase tracking-widest" data-nuevo-index="${index}" title="Quitar">×</button>
            `;
            item.querySelector('.admin-galeria-remove')?.addEventListener('click', () => {
                galeriaFilesPendientes.splice(index, 1);
                syncGaleriaInputFiles();
                renderGaleriaNuevasPreview();
            });
            galeriaNuevas.appendChild(item);
        });
    }

    function onGaleriaInputChange() {
        const nuevos = Array.from(galeriaInput?.files || []);
        if (!nuevos.length) return;

        nuevos.forEach((file) => {
            const duplicado = galeriaFilesPendientes.some(
                (f) => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified
            );
            if (!duplicado) {
                galeriaFilesPendientes.push(file);
            }
        });

        syncGaleriaInputFiles();
        renderGaleriaNuevasPreview();
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
        if (previewObjectUrl) URL.revokeObjectURL(previewObjectUrl);
        previewObjectUrl = null;
        imagenInput && (imagenInput.value = '');
        if (imagenActualInput) imagenActualInput.value = '';
        clearGaleriaPreviews();
        renderGaleriaExistente([]);
    }

    function hideMessages() {
        errorEl?.classList.add('hidden');
        successEl?.classList.add('hidden');
    }

    function showError(msg) {
        if (!errorEl) return;
        errorEl.textContent = msg;
        errorEl.classList.remove('hidden');
        successEl?.classList.add('hidden');
    }

    function fillCategorias(categorias, selectedId) {
        const select = document.getElementById('admin-categoria');
        if (!select) return;
        select.innerHTML = '';
        categorias.forEach((cat) => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.nombre;
            if (Number(cat.id) === Number(selectedId)) opt.selected = true;
            select.appendChild(opt);
        });
    }

    function populateForm(producto, categorias) {
        const imagenPath = producto?.imagen_principal || '';
        document.getElementById('admin-id').value = producto?.id || '';
        document.getElementById('admin-action').value = producto?.id ? 'update' : 'create';
        document.getElementById('admin-modal-title').textContent = producto?.id ? 'Editar producto' : 'Nuevo producto';
        document.getElementById('admin-nombre').value = producto?.nombre || '';
        document.getElementById('admin-precio').value = producto?.precio || '';
        if (imagenActualInput) imagenActualInput.value = imagenPath;
        // Solo mostrar URL externa en el campo; las rutas locales se conservan en el hidden.
        document.getElementById('admin-imagen').value = isExternalImage(imagenPath) ? imagenPath : '';
        imagenInput && (imagenInput.value = '');
        imagenPreview.src = imagenPath ? resolveImageSrc(imagenPath) : '';
        imagenPreview.classList.toggle('hidden', !imagenPath);
        renderGaleriaExistente(producto?.imagenes || []);
        clearGaleriaPreviews();
        document.getElementById('admin-descripcion').value = producto?.descripcion || '';
        document.getElementById('admin-lavado').value = producto?.lavado || '';
        document.getElementById('admin-fit').value = producto?.fit || '';
        document.getElementById('admin-material').value = producto?.material_info || '';
        document.getElementById('admin-tallas').value = (producto?.tallas || []).join(', ');
        document.getElementById('admin-activo').checked = producto?.id ? Number(producto.activo) === 1 : true;
        fillCategorias(categorias, producto?.categoria_id || categorias[0]?.id);
        deleteBtn?.classList.toggle('hidden', !producto?.id);
    }

    async function fetchJson(url, options = {}) {
        const res = await fetch(url, { credentials: 'same-origin', ...options });
        const text = await res.text();
        if (!text) throw new Error('El servidor no respondió.');
        try { return JSON.parse(text); } catch { throw new Error('Respuesta inválida del servidor.'); }
    }

    async function openEditModal(id) {
        hideMessages();
        try {
            const data = await fetchJson(`${apiUrl}?action=get&id=${id}`);
            if (!data.ok) { openModal(); showError(data.error || 'No se pudo cargar.'); return; }
            categoriasCache = data.categorias || [];
            populateForm(data.producto, categoriasCache);
            openModal();
        } catch { openModal(); showError('Error de conexión.'); }
    }

    async function openCreateModal() {
        hideMessages();
        try {
            const data = await fetchJson(`${apiUrl}?action=categorias`);
            categoriasCache = data.categorias || [];
            populateForm({ categoria_id: config.defaultCategoriaId || categoriasCache[0]?.id }, categoriasCache);
            openModal();
        } catch { showError('Error al preparar el formulario.'); }
    }

    imagenInput?.addEventListener('change', () => {
        const file = imagenInput.files?.[0];
        if (!file) {
            updatePreview(imagenActualInput?.value || imagenUrlInput?.value);
            return;
        }
        if (previewObjectUrl) URL.revokeObjectURL(previewObjectUrl);
        previewObjectUrl = URL.createObjectURL(file);
        imagenPreview.src = previewObjectUrl;
        imagenPreview.classList.remove('hidden');
    });

    imagenUrlInput?.addEventListener('input', () => {
        if (!imagenInput?.files?.length) {
            updatePreview(imagenUrlInput.value.trim() || imagenActualInput?.value);
        }
    });

    galeriaInput?.addEventListener('change', onGaleriaInputChange);

    function updatePreview(path) {
        if (!imagenPreview) return;
        if (!path) { imagenPreview.classList.add('hidden'); return; }
        imagenPreview.src = resolveImageSrc(path);
        imagenPreview.classList.remove('hidden');
    }

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideMessages();
        const formData = new FormData(form);
        formData.set('action', document.getElementById('admin-action').value);

        // Si no hay archivo nuevo ni URL externa, conservar la imagen actual.
        const urlExterna = (imagenUrlInput?.value || '').trim();
        const tieneArchivo = Boolean(imagenInput?.files?.length);
        if (!tieneArchivo && !urlExterna && imagenActualInput?.value) {
            formData.set('imagen_principal', '');
        }

        if (document.getElementById('admin-activo').checked) formData.set('activo', '1');
        else formData.delete('activo');
        try {
            const data = await fetchJson(apiUrl, { method: 'POST', body: formData });
            if (!data.ok) { showError(data.error || 'No se pudo guardar.'); return; }
            if (successEl) { successEl.textContent = data.message; successEl.classList.remove('hidden'); }
            setTimeout(() => closeModal(), 400);
            setTimeout(() => window.location.reload(), 500);
        } catch (err) { showError(err.message || 'Error de conexión.'); }
    });

    deleteBtn?.addEventListener('click', async () => {
        const id = document.getElementById('admin-id').value;
        if (!id || !confirm('¿Ocultar este producto?')) return;
        const fd = new FormData();
        fd.set('action', 'delete');
        fd.set('id', id);
        try {
            const data = await fetchJson(apiUrl, { method: 'POST', body: fd });
            if (!data.ok) showError(data.error || 'Error.');
            else window.location.reload();
        } catch { showError('Error de conexión.'); }
    });

    document.getElementById('admin-new-product')?.addEventListener('click', openCreateModal);
    document.getElementById('admin-modal-close')?.addEventListener('click', closeModal);
    document.getElementById('admin-cancel-btn')?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-admin-edit]');
        if (btn) { e.preventDefault(); e.stopPropagation(); openEditModal(btn.dataset.adminEdit); }
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
    window.openAdminProductModal = openEditModal;
    window.openAdminCreateModal = openCreateModal;
})();
