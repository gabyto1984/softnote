<?php
namespace Matiere\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Matiere\Service\MatiereManager;
use Matiere\Controller\MatiereController;

/**
 * This is the factory for MatiereController. Its purpose is to instantiate the
 * controller.
 */
class MatiereControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $matiereManager = $container->get(MatiereManager::class);
        return new MatiereController($entityManager, $matiereManager);
    }
}

