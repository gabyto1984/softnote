<?php
namespace Salle\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Salle\Service\SalleManager;
use Salle\Controller\SalleController;

/**
 * This is the factory for ClasseController. Its purpose is to instantiate the
 * controller.
 */
class SalleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $salleManager = $container->get(SalleManager::class);
        return new SalleController($entityManager, $salleManager);
    }
}

