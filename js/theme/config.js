/**
 * Tailwind en runtime ya no se usa (build local en css/tailwind.css).
 * Se conserva por compatibilidad si algún entorno aún carga este archivo.
 */
if (typeof window !== 'undefined' && window.DeportivoTokens) {
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: window.DeportivoTokens,
        },
    };
}
