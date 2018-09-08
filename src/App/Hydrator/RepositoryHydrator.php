<?php
declare(strict_types=1);

namespace App\Hydrator;

use App\Entity\Repository;
use Zend\Hydrator\ClassMethods;

/**
 * Class RepositoryHydrator
 *
 * @package App\Hydrator
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class RepositoryHydrator extends ClassMethods
{
    /**
     * @inheritdoc
     * @return object|Repository
     */
    public function hydrate(array $data, $object)
    {
        if ($data['name'] && !isset($data['owner'])) {
            $parts = explode('/', $data['name']);
            $data['owner'] = $parts[0];
            $data['repository'] = $parts[1];
        }

        return parent::hydrate($data, $object);
    }

}
