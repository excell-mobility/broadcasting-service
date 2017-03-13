<?php
namespace Broadcasting\Channel\Sms;

use GuzzleHttp\ClientInterface;
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
}