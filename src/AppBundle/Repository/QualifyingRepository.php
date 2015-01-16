<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * The result repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingRepository extends EntityRepository implements QualifyingRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function countPolePositionsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('q');
        $builder
            ->select($builder->expr()->count('q'))
            ->join('q.team', 't')
            ->where($builder->expr()->eq('q.position', ':position'))
            ->andWhere($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':position', 1)
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getBestGridByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('q');
        $builder
            ->select('q.position')
            ->join('q.team', 't')
            ->where($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':driver', $driverId)
            ->orderBy($builder->expr()->asc('q.position'))
            ->setMaxResults(1)
        ;

        $result = $builder->getQuery()->getOneOrNullResult();

        return (null !== $result) ? (int) array_shift($result) : 0;
    }
}
