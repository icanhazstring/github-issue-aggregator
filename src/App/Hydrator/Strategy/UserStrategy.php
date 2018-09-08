<?php
declare(strict_types=1);

namespace App\Hydrator\Strategy;

use App\Entity\NullableInterface;
use App\Entity\NullUser;
use App\Entity\User;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class UserStrategy
 *
 * @package App\Hydrator\Strategy
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class UserStrategy implements StrategyInterface
{
    private $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function extract($value)
    {
        if ($value instanceof NullableInterface) {
            return null;
        }

        return $this->hydrator->extract($value);
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value)
    {
        if (!$value) {
            return new NullUser();
        }

        return $this->hydrator->hydrate($value, new User());
    }
}
