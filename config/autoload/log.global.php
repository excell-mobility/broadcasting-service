<?php
return [
    'dependencies' => [
        'invokables' => [
            \Broadcasting\Api\ApiProblem::class => \Broadcasting\Api\ApiProblem::class,
        ],
        'factories' => [
        ],
    ],
    'middleware_pipeline' => [
        'error' => [
            'middleware' => [
                Broadcasting\Api\ApiProblem::class,
            ],
            'error' => true,
            'priority' => -10000
        ],
    ],
    'loslog' => [
        'log_dir' => 'data/log',
        'error_logger_file' => 'error.log',
        'exception_logger_file' => 'exception.log',
        'static_logger_file' => 'static.log',
        'http_logger_file' => 'http.log',
        'log_request' => false,
        'log_response' => false,
        'full' => true,
    ]
];

