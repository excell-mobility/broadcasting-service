<?php
namespace Broadcasting\Channel\Sms;

use Psr\Http\Message\ResponseInterface;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class MufaGateway extends AbstractSmsGateway
{
    /**
     * Sends the message $content to $contactId.
     *
     * @param string $contactId
     * @param string $content
     * @throws \Exception
     * @return ResponseInterface
     */
    public function send(string $contactId, string $content): ResponseInterface
    {
        $clientOptions = [
            'form_params' => [
                'input_recipient' => $this->formatPhoneNumber($contactId),
                'input_message' => $content
            ],
            'headers' => [
                'Host' => 'www.mufa.de',
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => $this->config['userAgents'][mt_rand(0, count($this->config['userAgents']) -1)],
                'X-Requested-With' => 'XMLHttpRequest'
            ],
            'timeout' => 30
        ];

        return $this->client->request('POST', 'http://www.mufa.de/free-sms.html', $clientOptions);
    }
}