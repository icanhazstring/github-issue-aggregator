<?php
declare(strict_types=1);

namespace App\Renderer;

use Interop\Container\ContainerInterface;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Zend\ServiceManager\Factory\FactoryInterface;

class PlatesEngineFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $engine = new Engine();

        $templatesConfig = $container->get('config')['templates'];
        $engine->loadExtension(new Asset($templatesConfig['paths']['htdocs']));

        return $engine;
    }
}
