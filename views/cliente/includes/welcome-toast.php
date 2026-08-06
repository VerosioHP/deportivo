<?php

if (empty($_SESSION['mostrar_bienvenida'])) {
    return;
}

$bienvenidaNombre = trim((string) ($_SESSION['nombre'] ?? ''));
if ($bienvenidaNombre === '') {
    $bienvenidaNombre = trim((string) ($_SESSION['email'] ?? 'VEMA'));
}

unset($_SESSION['mostrar_bienvenida']);
?>
<div class="welcome-toast" data-welcome-toast role="status" aria-live="polite">
    <div class="welcome-toast-card">
        <p class="welcome-toast-brand">VEMA</p>
        <p class="welcome-toast-msg">
            Hola <?= htmlspecialchars($bienvenidaNombre) ?>, bienvenido a VEMA.
        </p>
    </div>
</div>
<script>
(() => {
    const el = document.querySelector('[data-welcome-toast]');
    if (!el) return;
    requestAnimationFrame(() => el.classList.add('is-visible'));
    window.setTimeout(() => {
        el.classList.remove('is-visible');
        el.classList.add('is-leaving');
        window.setTimeout(() => el.remove(), 400);
    }, 3000);
})();
</script>
