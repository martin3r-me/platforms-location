<?php

return [
    'routing' => [
        'mode' => env('LOCATION_MODE', 'path'),
        'prefix' => 'location',
    ],
    'guard' => 'web',

    'navigation' => [
        'route' => 'location.dashboard',
        'icon'  => 'heroicon-o-map-pin',
        'order' => 30,
    ],

    'sidebar' => [
        [
            'group' => 'Allgemein',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'location.dashboard',
                    'icon'  => 'heroicon-o-home',
                ],
            ],
        ],
        [
            'group' => 'Verwaltung',
            'items' => [
                [
                    'label' => 'Sites',
                    'route' => 'location.sites.index',
                    'icon'  => 'heroicon-o-globe-alt',
                ],
                [
                    'label' => 'Locations',
                    'route' => 'location.locations.index',
                    'icon'  => 'heroicon-o-map-pin',
                ],
            ],
        ],
    ],
];
