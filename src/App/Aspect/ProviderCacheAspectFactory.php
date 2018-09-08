<?php
declare(strict_types=1);

namespace App\Aspect;

use Doctrine\Common\Cache\PredisCache;
use Interop\Container\ContainerInterface;
use Predis\Client;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProviderCacheAspectFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $cache = new PredisCache(new Client());

        return new ProviderCacheAspect($cache);
    }
}
