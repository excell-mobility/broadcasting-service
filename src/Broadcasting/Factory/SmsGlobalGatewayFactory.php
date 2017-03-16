<?php
namespace Broadcasting\Factory;

use Broadcasting\Channel\Sms\SmsGlobalGateway;
use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

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