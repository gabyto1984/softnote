<?php
namespace Eleve\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Eleve\Service\EleveManager;
use Eleve\Service\ImageManager;
use Eleve\Controller\EleveController;

/**
 * This is the factory for EleveController. Its purpose is to instantiate the
 * controller.
 */
class EleveControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $eleveManager = $container->get(EleveManager::class);
        $imageManager = $container->get(ImageManager::class);
        //$ContactManager = $container->get(ContactManager::class);
        // Instantiate the controller and inject dependencies
        return new EleveController($entityManager, $eleveManager, $imageManager);
    }
}

