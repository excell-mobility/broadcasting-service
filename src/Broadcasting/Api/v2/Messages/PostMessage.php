<?php
namespace Broadcasting\Api\v2\Messages;

use Broadcasting\Api\Validation;
use Broadcasting\Channel\Sms\AbstractSmsGateway;
use GuzzleHttp\Psr7\BufferStream;
use LosMiddleware\ApiProblem\Model\ApiProblem;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class PostMessage
{
    /**
     * Stores the config.
     * @var
     */
    protected $config;

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
     * @param  $config
     */
    public function __construct(
        AbstractSmsGateway $mufaGateway,
        AbstractSmsGateway $smsGlobalGateway,
        $config
    )
    {
        $this->mufaGateway = $mufaGateway;
        $this->smsGlobalGateway = $smsGlobalGateway;
        $this->config = $config;
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
        $bufferStream = new BufferStream();

        try {
            $chosenGateway->send($paramsDecoded->contactId, $paramsDecoded->content);
            $apiResponse = new ApiProblem(201, 'Created: Successful sent to sms provider!' , null, 'success');
            $response = $response->withStatus(201);

        } catch (\Exception $e) {
            $response = $response->withStatus(502);
            $apiResponse = new ApiProblem(502, 'Bad Gateway: Could not send sms because SMS Gateway was not accessible.');
        }

        $bufferStream->write(json_encode($apiResponse->toArray(), JSON_PRETTY_PRINT));
        return $response->withBody($bufferStream);
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
        $validation = new Validation($request, $this->config);

        // check auth header
        $validation->validateJwtAuthorizationHeader();

        // check given JSON data
        $validation->validateContentTypeApplicationJson();
        $decodedJson = $validation->validateContentIsValidJson();

        // check API parameters
        $validation->validateRequiredAttributes($decodedJson, ['channel', 'contactId', 'content', 'token']);
        $validation->validateStringValues($decodedJson, ['channel', 'contactId', 'content', 'token']);

        return $decodedJson;
    }
}