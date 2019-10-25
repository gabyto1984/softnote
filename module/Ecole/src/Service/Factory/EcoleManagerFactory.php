<?php
namespace Ecole\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Ecole\Service\EcoleManager;

/**
 * This is the factory for ClasseManager. Its purpose is to instantiate the
 * service.
 */
class EcoleManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new EcoleManager($entityManager);
    }
}

