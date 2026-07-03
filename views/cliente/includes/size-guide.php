<?php

/**
 * Tablas de guía de tallas por categoría (medidas en cm).
 */
function deportivo_guia_tallas(string $categoriaSlug): array
{
    $pantalonetas = [
        'titulo' => 'Guía de tallas — Pantalonetas',
        'unidad' => 'Todas las medidas están en centímetros.',
        'columnas' => ['Talla', 'Cintura', 'Cadera', 'Largo'],
        'filas' => [
            ['XS', '66–70', '86–90', '38'],
            ['S', '70–74', '90–94', '40'],
            ['M', '74–78', '94–98', '42'],
            ['L', '78–84', '98–104', '44'],
            ['XL', '84–90', '104–110', '46'],
            ['XXL', '90–96', '110–116', '48'],
        ],
        'consejos' => [
            'Mide la cintura a la altura del ombligo, sin apretar la cinta.',
            'Si estás entre dos tallas, elige la mayor para entrenamientos de alta intensidad.',
            'Las pantalonetas de compresión pueden sentirse más ajustadas; consulta la fila de cadera.',
        ],
    ];

    $camisetas = [
        'titulo' => 'Guía de tallas — Camisetas',
        'unidad' => 'Todas las medidas están en centímetros.',
        'columnas' => ['Talla', 'Pecho', 'Largo', 'Hombro'],
        'filas' => [
            ['XS', '86–90', '66', '40'],
            ['S', '90–94', '68', '42'],
            ['M', '94–98', '70', '44'],
            ['L', '98–104', '72', '46'],
            ['XL', '104–110', '74', '48'],
            ['XXL', '110–116', '76', '50'],
        ],
        'consejos' => [
            'Mide el pecho en la parte más ancha, con la cinta paralela al suelo.',
            'Para fit compresión, elige tu talla habitual; para fit holgado, sube una talla.',
            'Las telas técnicas pueden encoger ligeramente en el primer lavado en frío.',
        ],
    ];

    $mapa = [
        'camisetas' => $camisetas,
        'pantalonetas' => $pantalonetas,
        'pantalonetas-pro' => $pantalonetas,
        'jeans' => $pantalonetas,
    ];

    return $mapa[$categoriaSlug] ?? $camisetas;
}

function deportivo_guia_tallas_json(string $categoriaSlug): string
{
    return json_encode(deportivo_guia_tallas($categoriaSlug), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
