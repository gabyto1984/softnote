<?php
namespace Classeeleve\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Classeeleve\Service\ClasseeleveManager;

/**
 * This is the factory for EleveManager. Its purpose is to instantiate the
 * service.
 */
class ClasseeleveManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new ClasseeleveManager($entityManager);
    }
}

