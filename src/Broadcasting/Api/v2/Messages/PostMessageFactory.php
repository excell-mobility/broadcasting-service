<?php
namespace Broadcasting\Api\v2\Messages;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Short description for class
 *
 * Long description for class
 *
 * @package   Broadcasting Service
 * @copyright Copyright (c) 2017 ENTIRETEC (http://www.entiretec.com)
 */
class PostMessageFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null|null $options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PostMessage
    {
        $postMessage = new PostMessage(
            $container->get('Broadcasting\Channel\Sms\MufaGateway'),
            $container->get('Broadcasting\Channel\Sms\SmsGlobalGateway'),
            $container->get('config')
        );

        return $postMessage;
    }
}