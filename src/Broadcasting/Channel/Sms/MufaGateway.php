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
class MufaGateway extends AbstractSmsGateway
{
    /**
     * Store user agents for user agent rotation.
     * @var string[]
     */
    protected $userAgents = [
        'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:44.0) Gecko/20100101 Firefox/44.0',
        'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36',
        'Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; Microsoft; Lumia 640 XL)',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.5.2171.95 Safari/537.36',
        'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; Media Center PC 6.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C)'
    ];

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
        $response = $this->client->request(
            'POST',
            'http://www.mufa.de/free-sms.html',
            [
                'form_params' => [
                    'input_recipient' => $contactId,
                    'input_message' => $content
                ],
                'headers' => [
                    'Host' => 'www.mufa.de',
                    'Accept' => 'application/json, text/javascript, */*; q=0.01',
                    'Accept-Encoding' => 'gzip, deflate',
                    'Accept-Language' => 'en-US,en;q=0.5',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'User-Agent' => $this->userAgents[mt_rand(0, count($this->userAgents) -1)],
                    'X-Requested-With' => 'XMLHttpRequest'
                ],
                'timeout' => 30
            ]
        );

        $response;
    }
}