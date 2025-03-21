<?php

return [
    // Available locales
    'supportedLocales' => [
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_US',
        ],
        'ar' => [
            'name' => 'Arabic',
            'script' => 'Arab',
            'native' => 'العربية',
            'regional' => 'ar_AE',
            'dir' => 'rtl',
        ],
    ],

    // Hide default locale in URL
    'hideDefaultLocaleInURL' => false,

    // Use the locale middleware
    'useAcceptLanguageHeader' => true,

    // Locale separator in URLs
    'localeRoute' => true,
    'localeSeparator' => '/',

    // Prevent infinite redirections
    'maxLocaleRouteIterations' => 5
];
