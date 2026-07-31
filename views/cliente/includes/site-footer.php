<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

$mailConfig = is_file(dirname(__DIR__, 3) . '/config/mail.php')
    ? require dirname(__DIR__, 3) . '/config/mail.php'
    : [];
$instagramUrl = 'https://www.instagram.com/vema_col/';
$contactoEmail = $mailConfig['admin_email'] ?? ($mailConfig['from_email'] ?? 'hola@vema.co');
?>
<footer class="w-full bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant">
    <div class="footer-grid px-margin-mobile md:px-margin-desktop py-16 max-w-container-max-width mx-auto">
        <div class="footer-brand">
            <?php include __DIR__ . '/brand-logo.php'; ?>
            <p class="footer-tagline font-display-lg text-on-surface-variant max-w-sm mt-6 uppercase">
                Muévete hoy: cada entrenamiento suma. Tu cuerpo lo agradece y tu mente también.
            </p>
        </div>
        <div class="footer-socials">
            <a class="footer-social-link footer-social-link--instagram"
                href="<?= htmlspecialchars($instagramUrl) ?>"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Instagram VEMA">
                <svg class="footer-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <defs>
                        <radialGradient id="footer-ig-grad" cx="30%" cy="107%" r="150%">
                            <stop offset="0%" stop-color="#fdf497"/>
                            <stop offset="5%" stop-color="#fdf497"/>
                            <stop offset="45%" stop-color="#fd5949"/>
                            <stop offset="60%" stop-color="#d6249f"/>
                            <stop offset="90%" stop-color="#285AEB"/>
                        </radialGradient>
                    </defs>
                    <path fill="url(#footer-ig-grad)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 1.441c-3.17 0-3.548.012-4.796.07-2.662.122-3.938 1.41-4.06 4.06-.058 1.247-.069 1.618-.069 4.788 0 3.17.011 3.541.069 4.788.122 2.645 1.402 3.938 4.06 4.06 1.247.058 1.625.07 4.796.07 3.17 0 3.547-.012 4.796-.07 2.65-.121 3.939-1.404 4.06-4.06.058-1.247.07-1.618.07-4.788 0-3.17-.012-3.541-.07-4.788-.121-2.656-1.404-3.938-4.06-4.06-1.249-.058-1.626-.07-4.796-.07zm0 3.495a5.226 5.226 0 1 1 0 10.451 5.226 5.226 0 0 1 0-10.451zm0 8.622a3.396 3.396 0 1 0 0-6.792 3.396 3.396 0 0 0 0 6.792zm6.406-9.845a1.22 1.22 0 1 1-2.44 0 1.22 1.22 0 0 1 2.44 0z"/>
                </svg>
            </a>
            <a class="footer-social-link footer-social-link--gmail"
                href="mailto:<?= htmlspecialchars($contactoEmail) ?>"
                aria-label="Correo electrónico">
                <svg class="footer-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M22 6.5v11c0 .83-.67 1.5-1.5 1.5H17V9.37l-5 3.75-5-3.75V19H3.5C2.67 19 2 18.33 2 17.5v-11c0-.17.03-.33.08-.48L12 12.5l9.92-6.48c.05.15.08.31.08.48z"/>
                    <path fill="#EA4335" d="M3.5 5h3.75L12 9.12 16.75 5H20.5c.28 0 .54.08.75.21L12 12.5 2.75 5.21C2.96 5.08 3.22 5 3.5 5z"/>
                    <path fill="#FBBC05" d="M2 6.5V17.5c0 .28.08.54.21.75V7.88L2.08 6.02C2.03 6.17 2 6.33 2 6.5z"/>
                    <path fill="#34A853" d="M21.79 18.25c.13-.21.21-.47.21-.75V6.5c0-.17-.03-.33-.08-.48l-.13 1.86v9.87z"/>
                    <path fill="#C5221F" d="M17 19h3.5c.83 0 1.5-.67 1.5-1.5v-.25H17V19zM2 17.5c0 .83.67 1.5 1.5 1.5H7v-1.75H2.21c-.13.21-.21.47-.21.75z"/>
                </svg>
            </a>
        </div>
        <div class="footer-copy">
            <p class="footer-copyright font-headline-sm text-headline-sm text-on-surface-variant tracking-wide">VEMA 2026 ©</p>
        </div>
    </div>
</footer>
