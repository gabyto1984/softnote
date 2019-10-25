<?php
namespace Ecole\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Ecole\Service\EcoleManager;
use Ecole\Controller\EcoleController;

/**
 * This is the factory for ClasseController. Its purpose is to instantiate the
 * controller.
 */
class EcoleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $ecoleManager = $container->get(EcoleManager::class);
        return new EcoleController($entityManager, $ecoleManager);
    }
}

