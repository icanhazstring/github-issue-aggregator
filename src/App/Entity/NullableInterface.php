<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Interface NullableInterface
 *
 * @package App\Entity
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 * @codeCoverageIgnore
 */
interface NullableInterface
{
    /**
     * @return bool
     */
    public function isNull(): bool;
}
