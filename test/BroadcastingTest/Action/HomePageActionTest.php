<?php
namespace BroadcastingTest\Action;

use Broadcasting\Action\HomePageAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Stratigility\Next;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @author    André Rademacher <andre.rademacher@entiretec.com>
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 * @license   ENTIRETEC proprietery license
 */
class HomePageActionTest extends TestCase
{
    public function testReturnsHtmlResponse(): void
    {
        $homePageAction = new HomePageAction();
        $response = $homePageAction->process(
            new ServerRequest(),
            new Next(new \SplQueue())
        );
        $this->assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $response, 'nix!');
    }
}