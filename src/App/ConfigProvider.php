<?php

declare(strict_types=1);

namespace App;

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
                Cache\ProviderCacheInterface::class => Cache\MemoryProviderCache::class,
                Filter\RequirementFilter::class     => Filter\RequirementFilter::class,
                \Github\Client::class               => \Github\Client::class,
                \Packagist\Api\Client::class        => \Packagist\Api\Client::class
            ],
            'factories'  => [
                Handler\AuthHandler::class                 => ReflectionBasedAbstractFactory::class,
                Middleware\AuthenticationMiddleware::class => ReflectionBasedAbstractFactory::class,
                Service\PackagistService::class            => ReflectionBasedAbstractFactory::class,
                Provider\PackagistProvider::class          => ReflectionBasedAbstractFactory::class,
                Service\GithubService::class               => ReflectionBasedAbstractFactory::class,
                Provider\GithubProvider::class             => ReflectionBasedAbstractFactory::class,
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
            ],
        ];
    }
}
