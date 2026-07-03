(function () {
    try {
        var stored = localStorage.getItem("deportivo-theme");
        var prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        var isDark = stored === "dark" || (stored !== "light" && prefersDark);
        if (isDark) {
            document.documentElement.classList.add("dark");
        }
    } catch (e) {}
})();
