<?php

use Broadcasting\Api;
use Broadcasting\Action;

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
call_user_func(function () {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);

    // Import programmatic/declarative middleware pipeline and routing
    // configuration statements
    require 'config/pipeline.php';


    /**
     * API v2
     */

    /**
     * API v1
     */
    $app->post('/messages', Api\v1\Messages\PostMessage::class, 'api_v1_messages_post');

    /**
     * Websites
     */
    $app->get('/', Action\HomePageAction::class, 'home');



    /**
     * Setup routes with a single request method:
     *
     * $app->get('/', App\Action\HomePageAction::class, 'home');
     * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
     * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
     * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
     * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
     *
     * Or with multiple request methods:
     *
     * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
     */


    $app->run();
});
