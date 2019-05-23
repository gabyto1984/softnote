<?php
namespace Evaluation\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Evaluation\Service\EvaluationManager;

/**
 * This is the factory for EvaluationManager. Its purpose is to instantiate the
 * service.
 */
class EvaluationManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        // Instantiate the service and inject dependencies
        return new EvaluationManager($entityManager);
    }
}

