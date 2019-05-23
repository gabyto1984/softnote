<?php
namespace Evaluation\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Evaluation\Service\EvaluationManager;
use Evaluation\Controller\EvaluationController;
use Zend\View\Renderer\RendererInterface;

/**
 * This is the factory for EnseigneeController. Its purpose is to instantiate the
 * controller.
 */
class EvaluationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tcpdf = $container->get(\TCPDF::class);
        $renderer = $container->get(RendererInterface::class);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $evaluationManager = $container->get(EvaluationManager::class);
        return new EvaluationController($entityManager, $evaluationManager, $tcpdf, $renderer);
    }
}

