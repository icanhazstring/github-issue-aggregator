<?php
declare(strict_types=1);

namespace App\Service;

use App\Hydrator\RepositoryHydrator;
use App\Provider\PackagistProvider;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PackagistServiceFactory
 *
 * @package App\Service
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class PackagistServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PackagistService(
            $container->get(PackagistProvider::class),
            $container->get(RepositoryHydrator::class)
        );
    }

}
