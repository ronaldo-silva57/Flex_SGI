<?php

namespace App\Support;

class QuickChart
{
    /**
     * Monta a URL do QuickChart a partir de uma config Chart.js.
     */
    public static function url(array $config, int $w = 420, int $h = 240): string
    {
        // Estilo padrão para relatórios impressos
        $config += [
            'options' => [
                'plugins' => [
                    'legend' => ['labels' => ['font' => ['size' => 10]]],
                ],
            ],
        ];

        return 'https://quickchart.io/chart?'
            . http_build_query([
                'c'                  => json_encode($config),
                'w'                  => $w,
                'h'                  => $h,
                'backgroundColor'    => 'white',
                'devicePixelRatio'   => 2,
                'format'             => 'png',
            ]);
    }

    public static function doughnut(array $data, int $w = 300, int $h = 220): string
    {
        return self::url([
            'type' => 'doughnut',
            'data' => [
                'labels'   => array_keys($data),
                'datasets' => [[
                    'data'            => array_values($data),
                    'backgroundColor' => ['#10b981','#0ea5e9','#f59e0b','#ef4444','#8b5cf6','#14b8a6','#94a3b8','#6366f1'],
                ]],
            ],
        ], $w, $h);
    }

    public static function bar(array $data, int $w = 420, int $h = 240, string $cor = '#3b82f6'): string
    {
        return self::url([
            'type' => 'bar',
            'data' => [
                'labels'   => array_keys($data),
                'datasets' => [[
                    'data'            => array_values($data),
                    'backgroundColor' => $cor,
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales'  => ['y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]]],
            ],
        ], $w, $h);
    }
}