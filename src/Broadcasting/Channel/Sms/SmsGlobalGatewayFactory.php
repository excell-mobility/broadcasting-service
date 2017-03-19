<?php
namespace Broadcasting\Channel\Sms;

use GuzzleHttp\Client;
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
class SmsGlobalGatewayFactory implements FactoryInterface
{

    /**
     * Builds a SmsGlobalGateway.
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null|null $options
     * @return SmsGlobalGateway
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SmsGlobalGateway
    {
        $mufaGateway = new SmsGlobalGateway();
        $mufaGateway->setClient(new Client());
        $mufaGateway->setConfig($container->get('config')['channel']['sms']['SmsGlobalGateway']);
        $mufaGateway->setLogger($container->get('Zend\Log\Logger'));

        return $mufaGateway;
    }
}