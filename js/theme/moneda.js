(function () {
    'use strict';

    window.DEPORTIVO_MONEDA = {
        codigo: 'COP',
        simbolo: '$',
        envioGratisMin: 250000,
        envioCosto: 15000,
        format(amount) {
            const value = Math.round(Number(amount) || 0);
            return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },
    };
})();
