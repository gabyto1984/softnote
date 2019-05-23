<?php
namespace Anneescolaire\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Anneescolaire\Service\AnneescolaireManager;
use Anneescolaire\Controller\AnneescolaireController;

/**
 * This is the factory for MatiereController. Its purpose is to instantiate the
 * controller.
 */
class AnneescolaireControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $anneescolaireManager = $container->get(AnneescolaireManager::class);
        return new AnneescolaireController($entityManager, $anneescolaireManager);
    }
}

