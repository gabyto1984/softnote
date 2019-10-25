<?php
namespace Salle\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Salle\Service\SalleManager;

/**
 * This is the factory for ClasseManager. Its purpose is to instantiate the
 * service.
 */
class SalleManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new SalleManager($entityManager);
    }
}

