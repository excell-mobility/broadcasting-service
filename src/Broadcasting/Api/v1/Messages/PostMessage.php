<?php
namespace Broadcasting\Api\v1\Messages;

use Broadcasting\Channel\Sms\AbstractSmsGateway;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
class PostMessage
{

    /**
     * Stores the Mufa gateway.
     * @var AbstractSmsGateway
     */
    protected $mufaGateway;

    public function __construct(
        AbstractSmsGateway $mufaGateway
    )
    {
        $this->mufaGateway = $mufaGateway;
    }

    /**
     * Sends a message content to the contact id using the given channel. The token decides which provider to use.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null): ResponseInterface
    {
        throw new \Exception('jo', 400);
    }

    /**
     * Validates the request. If the request is invalid, an appropriate exception is thrown that leads
     *
     * @param ServerRequestInterface $request
     * @throws \Exception
     * @return void
     */
    public function validateRequest(ServerRequestInterface $request): void
    {

    }

    /**
     * Chooses an SMS gateway based on the token.
     *
     * @param string $token
     * @return AbstractSmsGateway
     */
    public function chooseGateway(string $token): AbstractSmsGateway
    {

    }
}