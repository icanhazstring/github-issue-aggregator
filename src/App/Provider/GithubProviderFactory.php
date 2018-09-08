<?php
declare(strict_types=1);

namespace App\Provider;

use Github\Client;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GithubProviderFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GithubProvider($container->get(Client::class));
    }
}
