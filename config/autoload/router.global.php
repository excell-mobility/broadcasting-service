<?php

use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\RouterInterface;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
    ],
];
