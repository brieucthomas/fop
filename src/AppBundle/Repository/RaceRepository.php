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
 * The race repository.
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
        $builder
            ->where($builder->expr()->gt('r.date', ':now'))
            ->andWhere($builder->expr()->eq('r.enabled', ':enabled'))
            ->setParameter(':now', new \DateTime())
            ->setParameter(':enabled', 1)
            ->orderBy($builder->expr()->asc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $builder->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRace()
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->where($builder->expr()->lt('r.date', ':now'))
            ->andWhere($builder->expr()->eq('r.enabled', ':enabled'))
            ->setParameter(':now', new \DateTime())
            ->setParameter(':enabled', 1)
            ->orderBy($builder->expr()->desc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $builder->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRaceWithResults()
    {
        $builder = $this->createQueryBuilder('r');
        $builder
            ->join('r.results', 'res', Expr\Join::WITH)
            ->where($builder->expr()->lt('r.date', ':now'))
            ->andWhere($builder->expr()->eq('r.enabled', ':enabled'))
            ->setParameter(':now', new \DateTime())
            ->setParameter(':enabled', 1)
            ->orderBy($builder->expr()->desc('r.date'))
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $builder->getQuery()->getOneOrNullResult();
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
