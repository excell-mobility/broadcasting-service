<?php
namespace Broadcasting\Channel\Sms;

use GuzzleHttp\ClientInterface;
use LosMiddleware\ApiProblem\Model\ApiProblem;
use Zend\Log\LoggerInterface;

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
abstract class AbstractSmsGateway
{

    /**
     * Stores the Guzzle HTTP client.
     * @var ClientInterface
     */
    protected $client;

    /**
     * Stores the config.
     * @var array
     */
    protected $config;

    /**
     * Stores the logger.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Sets the client.
     *
     * @param ClientInterface $client
     * @return AbstractSmsGateway
     */
    public function setClient(ClientInterface $client): AbstractSmsGateway
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Sets the config.
     *
     * @param array $config
     * @return AbstractSmsGateway
     */
    public function setConfig(array $config): AbstractSmsGateway
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Sets the logger.
     *
     * @param LoggerInterface $logger
     * @return AbstractSmsGateway
     */
    public function setLogger(LoggerInterface $logger): AbstractSmsGateway
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Validates the given token. True if successful, else false.
     *
     * @param string $token
     * @return bool
     */
    public function validateToken(string $token): bool
    {
        if ($this->config['token'] === $token) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Removes the leading "+" and replaces leading zero with given country prefix.
     *
     * @param string $phone
     * @param string $countryPrefix uses country code 49 for germany as default
     * @return string
     */
    public function formatPhoneNumber(string $phone, string $countryPrefix = '49'): string
    {
        // trim away leading & trailing spaces and after that leading "+"
        $phone = ltrim(trim($phone), '+');

        // replace leading zero with country code "49" for germany
        $firstChar = mb_substr($phone, 0, 1);
        if ($firstChar === '0') {
            $phone = $countryPrefix . mb_substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Sends the text message $content to $contactId.
     *
     * @param string $contactId
     * @param string $content
     * @throws \Exception
     * @return void
     */
    abstract public function send(string $contactId, string $content): void;
}