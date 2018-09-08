<?php
declare(strict_types=1);

namespace App\Hydrator;

use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;

class IssueHydratorFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('user', $container->get(Strategy\UserStrategy::class));
        $hydrator->addStrategy('assignee', $container->get(Strategy\UserStrategy::class));

        return $hydrator;
    }
}
