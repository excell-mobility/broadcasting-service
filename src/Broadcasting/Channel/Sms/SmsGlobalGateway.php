<?php
namespace Broadcasting\Channel\Sms;

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
class SmsGlobalGateway extends AbstractSmsGateway
{
    /**
     * Sends the message $content to $contactId.
     *
     * @param string $contactId
     * @param string $content
     * @throws \Exception
     * @return void
     */
    public function send(string $contactId, string $content): void
    {

    }
}