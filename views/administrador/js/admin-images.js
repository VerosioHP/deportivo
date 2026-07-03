(function () {
    'use strict';

    const config = window.ADMIN_IMAGE_CONFIG || {};
    const productConfig = window.ADMIN_CONFIG || {};

    if (!config.sitioApiUrl) {
        return;
    }

    const backdrop = document.getElementById('admin-image-backdrop');
    const modal = document.getElementById('admin-image-modal');
    const form = document.getElementById('admin-image-form');
    const typeInput = document.getElementById('admin-image-type');
    const keyInput = document.getElementById('admin-image-key');
    const productIdInput = document.getElementById('admin-image-product-id');
    const galleryIdInput = document.getElementById('admin-image-gallery-id');
    const hintEl = document.getElementById('admin-image-hint');
    const previewEl = document.getElementById('admin-image-preview');
    const fileInput = document.getElementById('admin-image-file');
    const urlInput = document.getElementById('admin-image-url');
    const errorEl = document.getElementById('admin-image-error');
    const successEl = document.getElementById('admin-image-success');

    let previewObjectUrl = null;
    let currentTrigger = null;

    const SITE_LABELS = {
        hero_main: 'Hero principal',
        running: 'Running',
        gym: 'Gimnasio',
        cycling: 'Ciclismo',
        tennis: 'Tenis',
        swimming: 'Natación',
        basketball: 'Básquet',
        yoga: 'Yoga',
        crossfit: 'CrossFit',
        camisetas: 'Panel camisetas',
        pantalonetas: 'Panel pantalonetas',
        nosotros_hero: 'Nosotros — hero',
        nosotros_tejido: 'Nosotros — tejido',
        nosotros_gym: 'Nosotros — gimnasio',
        login_side: 'Login lateral',
        catalogo_camisetas: 'Banner catálogo camisetas',
        catalogo_pantalonetas: 'Banner catálogo pantalonetas',
    };

    function resolveSrc(path) {
        if (!path) return '';
        if (/^https?:\/\//i.test(path) || path.startsWith('//')) return path;
        if (path.startsWith('/')) return path;
        return `${config.uploadsBasePath || ''}${path.replace(/^\//, '')}`;
    }

    function clearPreviewUrl() {
        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
            previewObjectUrl = null;
        }
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
        clearPreviewUrl();
        fileInput && (fileInput.value = '');
        urlInput && (urlInput.value = '');
        currentTrigger = null;
    }

    function setPreview(src) {
        if (!previewEl) return;
        if (!src) {
            previewEl.src = '';
            previewEl.classList.add('hidden');
            return;
        }
        previewEl.src = src;
        previewEl.classList.remove('hidden');
    }

    function openSiteImageModal(key, triggerEl) {
        currentTrigger = triggerEl;
        typeInput.value = 'site';
        keyInput.value = key;
        productIdInput.value = '';
        galleryIdInput.value = '';
        hintEl.textContent = `Imagen del sitio: ${SITE_LABELS[key] || key}. Los clientes verán el cambio al instante.`;
        setPreview(triggerEl?.src || '');
        hideMessages();
        openModal();
    }

    function openProductImageModal(productId, triggerEl) {
        currentTrigger = triggerEl;
        typeInput.value = 'product';
        keyInput.value = '';
        productIdInput.value = productId;
        galleryIdInput.value = '';
        hintEl.textContent = 'Imagen principal del producto. Haz clic en la tarjeta para editar todos los datos.';
        setPreview(triggerEl?.src || '');
        hideMessages();
        openModal();
    }

    function openGalleryImageModal(imagenId, productId, triggerEl) {
        currentTrigger = triggerEl;
        typeInput.value = 'gallery';
        keyInput.value = '';
        productIdInput.value = productId;
        galleryIdInput.value = imagenId;
        hintEl.textContent = 'Imagen de la galería del producto.';
        setPreview(triggerEl?.src || '');
        hideMessages();
        openModal();
    }

    function updateDomImages(type, detail) {
        if (type === 'site') {
            document.querySelectorAll(`[data-admin-site-image="${detail.key}"]`).forEach((img) => {
                img.src = detail.url;
            });
            return;
        }

        if (type === 'product') {
            document.querySelectorAll(`[data-admin-product-image="${detail.producto_id}"]`).forEach((img) => {
                img.src = detail.url;
            });
            document.querySelectorAll(`[data-product-card][data-product-id="${detail.producto_id}"] img`).forEach((img) => {
                if (!img.hasAttribute('data-admin-gallery-image')) {
                    img.src = detail.url;
                }
            });
            const main = document.getElementById('main-image');
            if (main && document.querySelector(`[data-admin-product-image="${detail.producto_id}"]`)) {
                main.src = detail.url;
            }
            document.querySelectorAll(`[data-add-to-cart][data-product-id="${detail.producto_id}"]`).forEach((btn) => {
                btn.dataset.productImagen = detail.url;
            });
            return;
        }

        if (type === 'gallery') {
            document.querySelectorAll(`[data-admin-gallery-image="${detail.imagen_id}"]`).forEach((img) => {
                img.src = detail.url;
            });
        }
    }

    fileInput?.addEventListener('change', () => {
        const file = fileInput.files?.[0];
        if (!file) {
            setPreview(currentTrigger?.src || '');
            return;
        }
        clearPreviewUrl();
        previewObjectUrl = URL.createObjectURL(file);
        setPreview(previewObjectUrl);
    });

    urlInput?.addEventListener('input', () => {
        if (fileInput?.files?.length) return;
        setPreview(urlInput.value.trim());
    });

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        hideMessages();

        const type = typeInput.value;
        const hasFile = Boolean(fileInput?.files?.length);
        const hasUrl = Boolean(urlInput?.value.trim());

        if (!hasFile && !hasUrl) {
            showError('Sube una imagen o indica una URL.');
            return;
        }

        const formData = new FormData();
        formData.set('desde_vistas', config.desdeVistas ? '1' : '0');

        if (hasFile) {
            formData.set('imagen_archivo', fileInput.files[0]);
        }
        if (hasUrl) {
            formData.set('url', urlInput.value.trim());
        }

        let apiUrl = config.sitioApiUrl;

        if (type === 'site') {
            formData.set('action', 'update');
            formData.set('key', keyInput.value);
        } else if (type === 'product') {
            formData.set('action', 'update_imagen');
            formData.set('producto_id', productIdInput.value);
            apiUrl = config.productoApiUrl || productConfig.apiUrl;
        } else if (type === 'gallery') {
            formData.set('action', 'update_imagen_galeria');
            formData.set('imagen_id', galleryIdInput.value);
            apiUrl = config.productoApiUrl || productConfig.apiUrl;
        }

        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            });
            const text = await response.text();

            if (!text) {
                showError('El servidor no respondió.');
                return;
            }

            let data;

            try {
                data = JSON.parse(text);
            } catch {
                showError('Respuesta inválida del servidor.');
                return;
            }

            if (!data.ok) {
                showError(data.error || 'No se pudo guardar la imagen.');
                return;
            }

            if (successEl) {
                successEl.textContent = data.message;
                successEl.classList.remove('hidden');
            }

            updateDomImages(type, data);

            setTimeout(closeModal, 500);
        } catch {
            showError('Error de conexión al guardar.');
        }
    });

    document.getElementById('admin-image-close')?.addEventListener('click', closeModal);
    document.getElementById('admin-image-cancel')?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);

    document.addEventListener('click', (event) => {
        const galleryImg = event.target.closest('[data-admin-gallery-image]');
        if (galleryImg) {
            event.preventDefault();
            event.stopPropagation();
            openGalleryImageModal(
                galleryImg.dataset.adminGalleryImage,
                galleryImg.dataset.adminProductId,
                galleryImg
            );
            return;
        }

        const productImg = event.target.closest('[data-admin-product-image]');
        if (productImg) {
            event.preventDefault();
            event.stopPropagation();
            openProductImageModal(productImg.dataset.adminProductImage, productImg);
            return;
        }

        const siteImg = event.target.closest('[data-admin-site-image]');
        if (siteImg) {
            event.preventDefault();
            event.stopPropagation();
            openSiteImageModal(siteImg.dataset.adminSiteImage, siteImg);
        }
    }, true);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
})();
