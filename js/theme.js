(function () {
    var STORAGE_KEY = "deportivo-theme";

    function getTheme() {
        return document.documentElement.classList.contains("dark") ? "dark" : "light";
    }

    function applyTheme(theme) {
        var isDark = theme === "dark";
        document.documentElement.classList.toggle("dark", isDark);
        localStorage.setItem(STORAGE_KEY, theme);
        updateToggleButtons(theme);
    }

    function updateToggleButtons(theme) {
        var isDark = theme === "dark";
        document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
            var icon = btn.querySelector(".theme-toggle-icon");
            if (icon) {
                icon.textContent = isDark ? "light_mode" : "dark_mode";
            }
            btn.setAttribute("aria-label", isDark ? "Activar modo claro" : "Activar modo oscuro");
            btn.setAttribute("aria-pressed", isDark ? "true" : "false");
        });
    }

    function initThemeToggle() {
        var stored = localStorage.getItem(STORAGE_KEY);
        if (stored === "dark" || stored === "light") {
            applyTheme(stored);
        } else {
            updateToggleButtons(getTheme());
        }

        document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
            if (btn.dataset.themeBound) return;
            btn.dataset.themeBound = "true";
            btn.addEventListener("click", function () {
                applyTheme(getTheme() === "dark" ? "light" : "dark");
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initThemeToggle);
    } else {
        initThemeToggle();
    }
})();
