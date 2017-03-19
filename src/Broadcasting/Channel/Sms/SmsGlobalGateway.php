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
class SmsGlobalGateway extends AbstractSmsGateway
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
        $url = 'http://www.smsglobal.com/http-api.php?action=sendsms&user=' . $this->config['user'] . '&password=' . $this->config['password']
            . '&from=' . $this->config['sendingServiceName'] . '&to=' . $this->formatPhoneNumber($contactId) . '&text=' . urlencode($content);

        $clientOptions = [
            'headers' => [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'X-Requested-With' => 'XMLHttpRequest'
            ],
            'timeout' => 30
        ];

        return $this->client->request('GET', $url, $clientOptions);
    }
}