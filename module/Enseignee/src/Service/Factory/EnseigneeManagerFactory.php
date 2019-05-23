<?php
namespace Enseignee\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Enseignee\Service\EnseigneeManager;

/**
 * This is the factory for EnseigneeManager. Its purpose is to instantiate the
 * service.
 */
class EnseigneeManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new EnseigneeManager($entityManager);
    }
}

