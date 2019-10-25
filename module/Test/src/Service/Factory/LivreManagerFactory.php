<?php
namespace Test\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Test\Service\LivreManager;

/**
 * This is the factory for ClasseManager. Its purpose is to instantiate the
 * service.
 */
class LivreManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new LivreManager($entityManager);
    }
}

