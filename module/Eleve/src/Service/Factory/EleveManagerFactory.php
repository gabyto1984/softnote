<?php
namespace Eleve\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Eleve\Service\EleveManager;

/**
 * This is the factory for EleveManager. Its purpose is to instantiate the
 * service.
 */
class EleveManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new EleveManager($entityManager);
    }
}

