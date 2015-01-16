<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Race;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The Race repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceRepository extends EntityRepository implements RaceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findNextRace()
    {
        $builder = $this->createQueryBuilder('r');
        $query   = $builder
            ->where($builder->expr()->gt('r.date', ':now'))
            ->setParameter(':now', new \DateTime())
            ->orderBy($builder->expr()->asc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRace()
    {
        $builder = $this->createQueryBuilder('r');
        $query   = $builder
            ->where($builder->expr()->lt('r.date', ':now'))
            ->setParameter(':now', new \DateTime())
            ->orderBy($builder->expr()->desc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRaceWithResults()
    {
        $builder = $this->createQueryBuilder('r');
        $query   = $builder
            ->join('r.results', 'res', Expr\Join::WITH)
            ->where($builder->expr()->lt('r.date', ':now'))
            ->setParameter(':now', new \DateTime())
            ->orderBy($builder->expr()->desc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Race $race)
    {
        $this
            ->persist($race)
            ->flush()
        ;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Race $race)
    {
        $this->_em->persist($race);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->_em->flush();

        return $this;
    }
}
