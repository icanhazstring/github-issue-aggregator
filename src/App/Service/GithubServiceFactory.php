<?php
declare(strict_types=1);

namespace App\Service;

use App\Filter\RequirementFilter;
use App\Hydrator\IssueHydrator;
use App\Provider\GithubProvider;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class GithubServiceFactory
 *
 * @package App\Service
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class GithubServiceFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new GithubService(
            $container->get(GithubProvider::class),
            $container->get(RequirementFilter::class),
            $container->get(IssueHydrator::class)
        );
    }
}
