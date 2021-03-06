<?php
namespace BroadcastingTest\Action;

use Broadcasting\Action\HomePageAction;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class HomePageActionTest extends TestCase
{
    public function testReturnsHtmlResponse(): void
    {
        $homePageAction = new HomePageAction();
        $response = $homePageAction(
            new ServerRequest(),
            new Response()
        );
        $this->assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $response, 'nix!');
    }
}