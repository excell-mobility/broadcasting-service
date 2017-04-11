<?php
namespace Broadcasting\Api;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha512;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class Validation
{
    /**
     * Stores the config.
     * @var array
     */
    protected $config;

    /**
     * Stores the Http request.
     * @var ServerRequestInterface $request
     */
    protected $request;

    /**
     * Validation constructor.
     * @param ServerRequestInterface $request
     * @param $config
     */
    public function __construct(ServerRequestInterface $request, $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    /**
     *  Checks the HTTP "Authorization" header for a valid JSON web token.
     *
     * @throws \Exception
     */
    public function validateJwtAuthorizationHeader()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        // check for HTTP "Authorization" header
        if (empty($authHeader) || ('JWT' !== substr($authHeader, 0, 3))) {
            throw new \Exception('Authorization via JSON web token is mandatory.', 401);
        }

        // parse token string
        $tokenString = substr($authHeader, 4);
        try {
            $jwt = (new Parser())->parse($tokenString);
        } catch (\Exception $e) {
            throw new \Exception('Error while parsing JSON web token', 400);
        }

        // verify signature before using the values
        $verified = $jwt->verify(new Sha512(), new Key($this->config['jwt']['il_public_key_file']));
        if (!$verified) {
            throw new \Exception('Could not verify the token signature using the ExCELL Intermediate CA certificate!', 400);
        }

        // validate token content
        if ($this->config['jwt']['expire'] && $jwt->isExpired(new \DateTime())) {
            throw new \Exception('Your authorization token has expired.', 407);
        };

        // only allow tokens from ExCELL integration layer
        if (!$jwt->hasClaim('iss') || ($jwt->getClaim('iss') !== $this->config['jwt']['issuer'])) {
            throw new \Exception('The token\'s issuer has to be the ExCELL Integration Layer (' . $this->config['jwt']['issuer'] . ')', 400);
        }

        // the targeted service has to be the broadcasting service
        if (!$jwt->hasClaim('service') || ($jwt->getClaim('service') !== $this->request->getUri()->getHost())) {
            throw new \Exception('The token\'s service has to be the ExCELL Broadcasting Service (' . $this->request->getUri()->getHost() . ')', 400);
        }
    }

    /**
     * Checks if the HTTP header "Content-Type" is set to "application/json", otherwise a HTTP Error 400 Bad Request is returned.
     *
     * @throws \Exception
     */
    public function validateContentTypeApplicationJson()
    {
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (false === strpos($contentType, 'application/json')) {
            throw new \Exception('Content-Type application/json is mandatory.', 415);
        }
    }

    /**
     * Checks the HTTP Content for valid JSON. If successful, the JSON decoded body is returned.
     *
     * @throws \Exception
     * @return \StdClass
     */
    public function validateContentIsValidJson()
    {
        $content = $this->request->getBody();
        $decodedBody = json_decode($content);
        if (json_last_error() !== JSON_ERROR_NONE ) {
            throw new \Exception('The given JSON is invalid: ' . json_last_error_msg(), 400);
        }

        if (!($decodedBody instanceof \StdClass)) {
            throw new \Exception('The given JSON is not an object.', 400);
        }

        return $decodedBody;
    }

    /**
     * Checks whether all the required attributes are set in the decoded JSON .
     *
     * @param \StdClass $decodedJson
     * @param array $requiredAttributes
     * @throws \Exception
     */
    public function validateRequiredAttributes(\StdClass $decodedJson, array $requiredAttributes)
    {
        foreach ($requiredAttributes as $requiredAttribute) {
            if (!isset($decodedJson->{$requiredAttribute})) {
                throw new \Exception('Missing required attribute: ' . $requiredAttribute, 400);
            }
        }
    }

    /**
     * Checks whether all the given attributes are of the type "string".
     *
     * @param \StdClass $decodedJson
     * @param array $stringAttributes
     * @throws \Exception
     */
    public function validateStringValues(\StdClass $decodedJson, array $stringAttributes)
    {
        foreach ($stringAttributes as $stringAttribute) {
            if (!is_string($decodedJson->{$stringAttribute})) {
                throw new \Exception('Attribute ' . $stringAttribute . ' has to be a string.', 400);
            }
        }
    }

    public function validateClientCertificate()
    {
        // check if HTTPS is enabled
        $this->validateHttpsIsEnabled();
        $this->validateClientCertificateIsSent();
        $this->validateClientCertificateSuccessfulVerified();
    }

    /**
     * Checks if the request was sent using HTTPS and HTTPS is enabled.
     *
     * @throws \Exception
     */
    public function validateHttpsIsEnabled()
    {
        if (!(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']))) {
            throw new \Exception('HTTPS is not enabled, please check your vhost configuration to force HTTPS in any case.', 500);
        }
    }

    /**
     * Checks if a client certificate was sent.
     *
     * @throws \Exception
     */
    public function validateClientCertificateIsSent()
    {
        if (!(isset($_SERVER['SSL_CLIENT_V_END']) && !empty($_SERVER['SSL_CLIENT_V_END']))) {
            throw new \Exception('SSL client certificate was not sent.', 401);
        }
    }

    /**
     * Checks if the client certificate was successfully verified using the public ExCELL Intermediate CA certificate.
     * Client certificate verification is done by the web server.
     *
     * @throws \Exception
     */
    public function validateClientCertificateSuccessfulVerified()
    {
        if (!(isset($_SERVER['SSL_CLIENT_VERIFY']) && $_SERVER['SSL_CLIENT_VERIFY'] === 'SUCCESS')) {
            throw new \Exception('SSL client certificate could not be verified successfully.', 401);
        }
    }
}