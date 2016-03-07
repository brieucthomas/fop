<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The team repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TeamRepository extends EntityRepository implements TeamRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        $builder = $this->createQueryBuilder('t');
        $builder
            ->where($builder->expr()->eq('t.season', ':year'))
            ->setParameter(':year', $year)
            ->orderBy($builder->expr()->desc('t.constructor'))
        ;

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function findByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('t');
        $builder
            ->where($builder->expr()->eq('t.driver', ':driver'))
            ->setParameter(':driver', $driverId)
            ->orderBy($builder->expr()->desc('t.season'))
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function save(Team $team)
    {
        $this->_em->persist($team);
        $this->_em->flush();
    }
}
