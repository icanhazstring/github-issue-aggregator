<?php

declare(strict_types=1);

namespace App;

use League\Plates\Engine;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Filter\RequirementFilter::class    => Filter\RequirementFilter::class,
                \Packagist\Api\Client::class       => \Packagist\Api\Client::class,
                Hydrator\RepositoryHydrator::class => Hydrator\RepositoryHydrator::class,
                Utils\RepositoryUtils::class       => Utils\RepositoryUtils::class
            ],
            'factories'  => [
                Aspect\ProviderCacheAspect::class          => Aspect\ProviderCacheAspectFactory::class,
                Engine::class                              => Renderer\PlatesEngineFactory::class,
                Hydrator\IssueHydrator::class              => Hydrator\IssueHydratorFactory::class,
                Hydrator\Strategy\UserStrategy::class      => Hydrator\Strategy\UserStrategyFactory::class,
                \Github\Client::class                      => Client\GithubClientFactory::class,
                Handler\AuthHandler::class                 => ReflectionBasedAbstractFactory::class,
                Middleware\AuthenticationMiddleware::class => ReflectionBasedAbstractFactory::class,
                Service\PackagistService::class            => Service\PackagistServiceFactory::class,
                Provider\PackagistProvider::class          => Provider\PackagistProviderFactory::class,
                Service\GithubService::class               => Service\GithubServiceFactory::class,
                Provider\GithubProvider::class             => Provider\GithubProviderFactory::class,
                Handler\HomePageHandler::class             => ReflectionBasedAbstractFactory::class,
                Handler\RepositoryHandler::class           => ReflectionBasedAbstractFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
                'htdocs' => __DIR__ . '/../../public',
            ],
        ];
    }
}
