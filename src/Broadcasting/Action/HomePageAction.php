<?php
namespace Broadcasting\Action;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class HomePageAction
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null): ResponseInterface
    {
        $query = $request->getQueryParams();
        $target = $query['target'] ?? 'World';

        // escape user input with htmlspecialchars()
        $target = htmlspecialchars($target, ENT_HTML5, 'UTF-8');

        return new HtmlResponse(
            sprintf(
                '<h1>Hello, %s!</h1>',
                $target
            )
        );
    }
}