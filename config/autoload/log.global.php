<?php
return [
    'dependencies' => [
        'invokables' => [
            LosMiddleware\ApiProblem\ApiProblem::class => LosMiddleware\ApiProblem\ApiProblem::class,
        ],
        'factories' => [
        ],
    ],
    'middleware_pipeline' => [
        'error' => [
            'middleware' => [
                LosMiddleware\ApiProblem\ApiProblem::class,
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