<?php
namespace Anneescolaire\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Anneescolaire\Service\AnneescolaireManager;

/**
 * This is the factory for MatireManager. Its purpose is to instantiate the
 * service.
 */
class AnneescolaireManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new AnneescolaireManager($entityManager);
    }
}

