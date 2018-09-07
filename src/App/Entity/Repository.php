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
    public function __construct($data)
    {
        parent::__construct($data, self::ARRAY_AS_PROPS);
    }
}
