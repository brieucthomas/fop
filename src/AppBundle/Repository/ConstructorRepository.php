<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The Constructor repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorRepository extends EntityRepository implements ConstructorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByIds(array $ids)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('c')
            ->from($this->_entityName, 'c', 'c.id')
            ->where($builder->expr()->in('c.id', ':ids'))
            ->setParameter(':ids', $ids)
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }
}
