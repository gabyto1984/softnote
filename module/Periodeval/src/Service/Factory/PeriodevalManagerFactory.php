<?php
namespace Periodeval\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Periodeval\Service\PeriodevalManager;

/**
 * This is the factory for MatireManager. Its purpose is to instantiate the
 * service.
 */
class PeriodevalManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new PeriodevalManager($entityManager);
    }
}

