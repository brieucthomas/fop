<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Race;
use AppBundle\Entity\Result;
use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;

/**
 * The result repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ResultRepository extends EntityRepository implements ResultRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(Result $result)
    {
        $this->_em->persist($result);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function countWinsByConstructor($constructorId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select($builder->expr()->count('r.position'))
            ->join('r.team', 't')
            ->where($builder->expr()->eq('r.position', ':position'))
            ->andWhere($builder->expr()->eq('t.constructor', ':constructor'))
            ->setParameter(':position', 1)
            ->setParameter(':constructor', $constructorId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countWinsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select($builder->expr()->count('r.position'))
            ->join('r.team', 't')
            ->where($builder->expr()->eq('r.position', ':position'))
            ->andWhere($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':position', 1)
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countPodiumsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select($builder->expr()->count('r.position'))
            ->join('r.team', 't')
            ->where($builder->expr()->gte('r.position', ':position'))
            ->andWhere($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':position', 3)
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    public function countPointsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select('SUM(r.points)')
            ->join('r.team', 't')
            ->where($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countFastestLapsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select($builder->expr()->count('r.fastestLap'))
            ->join('r.team', 't')
            ->where($builder->expr()->eq('r.fastestLapRank', ':rank'))
            ->andWhere($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':rank', 1)
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countResultsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select($builder->expr()->count('r.position'))
            ->join('r.team', 't')
            ->andWhere($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':driver', $driverId)
        ;

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getBestPositionByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->select('r.position')
            ->join('r.team', 't')
            ->where($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':driver', $driverId)
            ->orderBy($builder->expr()->asc('r.position'))
            ->setMaxResults(1)
        ;

        $result = $builder->getQuery()->getOneOrNullResult();

        return (null !== $result) ? (int) array_shift($result) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->join('r.race', 'race')
            ->where($builder->expr()->eq('race.season', ':season'))
            ->setParameter(':season', $season)
        ;

        $entities = $builder->getQuery()->execute();

        foreach ($entities as $entity) {
            $this->_em->remove($entity);
        }

        $this->_em->flush();
    }
}
