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
        [
            'group' => 'Settings',
            'items' => [
                [
                    'label' => 'Occasions',
                    'route' => 'location.settings.occasions.index',
                    'icon'  => 'heroicon-o-calendar-days',
                ],
                [
                    'label' => 'Bestuhlungen',
                    'route' => 'location.settings.seatings.index',
                    'icon'  => 'heroicon-o-square-3-stack-3d',
                ],
                [
                    'label' => 'Mietpreise',
                    'route' => 'location.settings.pricings.index',
                    'icon'  => 'heroicon-o-banknotes',
                ],
            ],
        ],
    ],
];
