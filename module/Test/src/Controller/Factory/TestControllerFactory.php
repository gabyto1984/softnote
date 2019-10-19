<?php
namespace Classe\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Classe\Service\ClasseManager;
use Classe\Controller\ClasseController;

/**
 * This is the factory for ClasseController. Its purpose is to instantiate the
 * controller.
 */
class ClasseControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $classeManager = $container->get(ClasseManager::class);
        return new ClasseController($entityManager, $classeManager);
    }
}

