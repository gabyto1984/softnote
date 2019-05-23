<?php
namespace Periodeval\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Periodeval\Service\PeriodevalManager;
use Periodeval\Controller\PeriodevalController;

/**
 * This is the factory for MatiereController. Its purpose is to instantiate the
 * controller.
 */
class PeriodevalControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $periodevalManager = $container->get(PeriodevalManager::class);
        return new PeriodevalController($entityManager, $periodevalManager);
    }
}

