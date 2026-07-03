<div id="size-guide-backdrop" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true"></div>

<aside id="size-guide-modal" class="fixed top-0 right-0 h-full w-full max-w-lg bg-surface dark:bg-on-background border-l border-outline-variant dark:border-outline z-[70] flex flex-col shadow-2xl translate-x-full transition-transform duration-300 ease-out" aria-label="Guía de tallas" role="dialog" aria-modal="true">
    <div class="flex items-center justify-between px-margin-mobile md:px-8 py-6 border-b border-outline-variant">
        <h2 id="size-guide-title" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed uppercase tracking-widest">Guía de tallas</h2>
        <button type="button" id="size-guide-close" class="text-on-surface-variant hover:text-secondary transition-colors" aria-label="Cerrar guía de tallas">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-margin-mobile md:px-8 py-6">
        <p id="size-guide-unit" class="font-body-md text-body-md text-on-surface-variant mb-6"></p>

        <div class="overflow-x-auto border border-outline-variant">
            <table class="size-guide-table w-full min-w-[280px]">
                <thead>
                    <tr id="size-guide-head"></tr>
                </thead>
                <tbody id="size-guide-body"></tbody>
            </table>
        </div>

        <div class="mt-8">
            <h3 class="font-label-md text-label-md uppercase tracking-widest text-primary mb-4">Consejos de medición</h3>
            <ul id="size-guide-tips" class="flex flex-col gap-3 font-body-md text-body-md text-on-surface-variant list-disc list-inside"></ul>
        </div>
    </div>
</aside>
