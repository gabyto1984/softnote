<?php
namespace Enseignee\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Enseignee\Service\EnseigneeManager;
use Enseignee\Controller\EnseigneeController;

/**
 * This is the factory for EnseigneeController. Its purpose is to instantiate the
 * controller.
 */
class EnseigneeControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $enseigneeManager = $container->get(EnseigneeManager::class);
        return new EnseigneeController($entityManager, $enseigneeManager);
    }
}

