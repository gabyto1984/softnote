<?php
namespace Test\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Test\Service\LivreManager;
use Test\Service\PersonneManager;
use Test\Controller\TestController;

/**
 * This is the factory for ClasseController. Its purpose is to instantiate the
 * controller.
 */
class TestControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $livreManager = $container->get(LivreManager::class);
        $personneManager = $container->get(PersonneManager::class);
        return new TestController($entityManager, $livreManager, $personneManager);
    }
}

