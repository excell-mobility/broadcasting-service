<?php
namespace Broadcasting\Api\v1\Messages;

use Broadcasting\Api\Validation;
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

    /**
     * Stores the SmsGlobal gateway.
     * @var AbstractSmsGateway
     */
    protected $smsGlobalGateway;

    /**
     * PostMessage constructor.
     * @param AbstractSmsGateway $mufaGateway
     * @param AbstractSmsGateway $smsGlobalGateway
     */
    public function __construct(
        AbstractSmsGateway $mufaGateway,
        AbstractSmsGateway $smsGlobalGateway
    )
    {
        $this->mufaGateway = $mufaGateway;
        $this->smsGlobalGateway = $smsGlobalGateway;
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
        $paramsDecoded = $this->validate($request);
        $chosenGateway = $this->chooseGateway($paramsDecoded->token);
        $jo = $chosenGateway->send($paramsDecoded->contactId, $paramsDecoded->content);
    }

    /**
     * Chooses an SMS gateway based on the token.
     *
     * @param string $token
     * @return AbstractSmsGateway
     */
    public function chooseGateway(string $token): AbstractSmsGateway
    {
        // check free sms provider first
        if ($this->mufaGateway->validateToken($token)) {
            return $this->mufaGateway;
        }

        if ($this->smsGlobalGateway->validateToken($token)) {
            return $this->smsGlobalGateway;
        }
    }

    /**
     * Do the validation and return the decoded JSON Object if successful.
     *
     * @param ServerRequestInterface $request
     * @return \StdClass
     */
    public function validate(ServerRequestInterface $request): \StdClass
    {
        $validation = new Validation($request);
        $validation->validateContentTypeApplicationJson();
        $decodedJson = $validation->validateContentIsValidJson();

        // check API parameters
        $validation->validateRequiredAttributes($decodedJson, ['channel', 'contactId', 'content', 'token']);
        $validation->validateStringValues($decodedJson, ['channel', 'contactId', 'content', 'token']);

        return $decodedJson;
    }
}