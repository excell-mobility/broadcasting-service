<?php
namespace Broadcasting\Factory;

use Broadcasting\Channel\Sms\MufaGateway;
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
class MufaGatewayFactory implements FactoryInterface
{

    /**
     * Builds a MufaGateway
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null|null $options
     * @return MufaGateway
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MufaGateway
    {
        $mufaGateway = new MufaGateway();
        $mufaGateway->setClient(new Client());
        $mufaGateway->setLogger($container->get('Zend\Log\Logger'));

        return $mufaGateway;
    }
}