<?php
namespace Broadcasting;

use Interop\Container\ContainerInterface;
use Zend\Log\LoggerInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
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
class LoggerFactory implements FactoryInterface
{

    /**
     * Builds a Zend Log logger.
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null|null $options
     * @return LoggerInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): LoggerInterface
    {
        $writer = new Stream('./data/log/error_' . date('Y-m-d') . '.log');
        $logger = new Logger();
        $logger->addWriter($writer);

        return $logger;
    }
}