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
    const imagenPreview = document.getElementById('admin-imagen-preview');
    const coloresList = document.getElementById('admin-colores-list');
    let categoriasCache = [];
    let previewObjectUrl = null;

    function resolveImageSrc(path) {
        if (!path) return '';
        if (/^https?:\/\//i.test(path) || path.startsWith('//')) return path;
        if (path.startsWith('/')) return path;
        return `${config.uploadsBasePath || ''}${path.replace(/^\//, '')}`;
    }

    function escapeAttr(v) {
        return String(v).replace(/&/g, '&amp;').replace(/"/g, '&quot;');
    }

    function createColorRow(color = {}) {
        const row = document.createElement('div');
        row.className = 'admin-color-row grid grid-cols-1 sm:grid-cols-[1fr_120px_auto] gap-3 items-end border border-outline-variant p-3';
        row.innerHTML = `
            <div>
                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Color</label>
                <input class="w-full py-2 bg-transparent border-0 border-b border-outline-variant focus:border-secondary font-body-md" name="colores_nombre[]" type="text" placeholder="Blanco, Negro, Gris..." value="${escapeAttr(color.nombre || '')}" required />
            </div>
            <div>
                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Stock</label>
                <input class="w-full py-2 bg-transparent border-0 border-b border-outline-variant focus:border-secondary font-body-md" name="colores_stock[]" type="number" min="0" step="1" value="${escapeAttr(color.stock_cantidad ?? 0)}" required />
            </div>
            <button type="button" class="admin-remove-row text-error font-label-sm uppercase tracking-widest hover:underline pb-2">Quitar</button>
        `;
        row.querySelector('.admin-remove-row')?.addEventListener('click', () => {
            if (coloresList.querySelectorAll('.admin-color-row').length <= 1) {
                showError('Debe haber al menos un color.');
                return;
            }
            row.remove();
        });
        return row;
    }

    function renderColores(colores) {
        if (!coloresList) return;
        coloresList.innerHTML = '';
        (colores?.length ? colores : [{}]).forEach((c) => coloresList.appendChild(createColorRow(c)));
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
        renderColores([]);
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
        document.getElementById('admin-id').value = producto?.id || '';
        document.getElementById('admin-action').value = producto?.id ? 'update' : 'create';
        document.getElementById('admin-modal-title').textContent = producto?.id ? 'Editar producto' : 'Nuevo producto';
        document.getElementById('admin-nombre').value = producto?.nombre || '';
        document.getElementById('admin-precio').value = producto?.precio || '';
        document.getElementById('admin-imagen').value = producto?.imagen_principal || '';
        imagenInput && (imagenInput.value = '');
        imagenPreview.src = producto?.imagen_principal ? resolveImageSrc(producto.imagen_principal) : '';
        imagenPreview.classList.toggle('hidden', !producto?.imagen_principal);
        document.getElementById('admin-descripcion').value = producto?.descripcion || '';
        document.getElementById('admin-lavado').value = producto?.lavado || '';
        document.getElementById('admin-fit').value = producto?.fit || '';
        document.getElementById('admin-material').value = producto?.material_info || '';
        document.getElementById('admin-tallas').value = (producto?.tallas || []).join(', ');
        document.getElementById('admin-activo').checked = producto?.id ? Number(producto.activo) === 1 : true;
        fillCategorias(categorias, producto?.categoria_id || categorias[0]?.id);
        renderColores(producto?.colores || []);
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
        if (!file) { updatePreview(imagenUrlInput?.value); return; }
        if (previewObjectUrl) URL.revokeObjectURL(previewObjectUrl);
        previewObjectUrl = URL.createObjectURL(file);
        imagenPreview.src = previewObjectUrl;
        imagenPreview.classList.remove('hidden');
    });

    imagenUrlInput?.addEventListener('input', () => {
        if (!imagenInput?.files?.length) updatePreview(imagenUrlInput.value.trim());
    });

    function updatePreview(path) {
        if (!imagenPreview) return;
        if (!path) { imagenPreview.classList.add('hidden'); return; }
        imagenPreview.src = resolveImageSrc(path);
        imagenPreview.classList.remove('hidden');
    }

    document.getElementById('admin-add-color')?.addEventListener('click', () => coloresList?.appendChild(createColorRow()));

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideMessages();
        if (!coloresList?.querySelector('.admin-color-row')) {
            showError('Agrega al menos un color con stock.');
            return;
        }
        const formData = new FormData(form);
        formData.set('action', document.getElementById('admin-action').value);
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
