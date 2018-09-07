<?php
declare(strict_types=1);

namespace App\Entity;

use Zend\Stdlib\ArrayObject;

/**
 * Repository
 *
 * @property string name
 * @property string repository
 *
 * @author Andreas Frömer <andreas.froemer@check24.de>
 */
class Repository extends ArrayObject
{
    public function __construct(string $name, string $repository)
    {
        parent::__construct([
            'name' => $name,
            'repository' => $repository
        ], self::ARRAY_AS_PROPS);
    }
}
