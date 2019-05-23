<?php
namespace Matiere\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Matiere\Service\MatiereManager;

/**
 * This is the factory for MatireManager. Its purpose is to instantiate the
 * service.
 */
class MatiereManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new matiereManager($entityManager);
    }
}

