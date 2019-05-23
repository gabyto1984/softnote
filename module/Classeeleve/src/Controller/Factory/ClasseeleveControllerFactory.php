<?php
namespace Classeeleve\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Classeeleve\Service\ClasseeleveManager;
use Classeeleve\Controller\ClasseeleveController;

/**
 * This is the factory for ConfigurationController. Its purpose is to instantiate the
 * controller.
 */
class ClasseeleveControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $classeeleveManager = $container->get(ClasseeleveManager::class);
        return new ClasseeleveController($entityManager, $classeeleveManager);
    }
}

