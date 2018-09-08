<?php

declare(strict_types=1);

use Zend\ConfigAggregator\ConfigAggregator;

return [
    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => true,

    // Enable debugging; typically used to provide debugging information within templates.
    'debug'                        => false,

    'goaop_module' => [
        'appDir'       => __DIR__ . '/../../',
        'cacheDir'     => __DIR__ . '/../../data/cache',
        'includePaths' => [
            __DIR__ . '/../../src/App/Provider'
        ],
        'excludePaths' => [
            __DIR__ . '/../../vendor'
        ]
    ],

    'goaop_aspect' => [
        \App\Aspect\ProviderCacheAspect::class
    ],

    'zend-expressive' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_404'   => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
];
