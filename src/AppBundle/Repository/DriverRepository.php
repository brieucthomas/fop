<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The Driver repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverRepository extends EntityRepository implements DriverRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByIds(array $ids)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('d')
            ->from($this->_entityName, 'd', 'd.id')
            ->where($builder->expr()->in('d.id', ':ids'))
            ->setParameter(':ids', $ids)
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }
}
