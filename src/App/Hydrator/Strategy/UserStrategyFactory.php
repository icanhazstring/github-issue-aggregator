<?php
declare(strict_types=1);

namespace App\Hydrator\Strategy;

use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UserStrategyFactory
 *
 * @package App\Hydrator\Strategy
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class UserStrategyFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserStrategy(new ClassMethods());
    }
}
