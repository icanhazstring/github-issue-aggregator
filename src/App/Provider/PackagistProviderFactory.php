<?php
declare(strict_types=1);

namespace App\Provider;

use Interop\Container\ContainerInterface;
use Packagist\Api\Client;
use Zend\ServiceManager\Factory\FactoryInterface;

class PackagistProviderFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PackagistProvider($container->get(Client::class));
    }
}
