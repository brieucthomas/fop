<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The driver standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandingsRepository extends EntityRepository implements DriverStandingsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('race')
            ->from('AppBundle:Race', 'race')
            ->join('race.results', 'results')
            ->where($builder->expr()->eq('race.season', ':year'))
            ->orderBy($builder->expr()->desc('race.date'))
            ->setParameter(':year', $year)
            ->setMaxResults(1)
        ;
        $race = $builder->getQuery()->getOneOrNullResult();

        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('ds.position', 'ds.points', 'ds.wins', 'd.firstName', 'd.lastName', 'c.slug as constructorSlug', 'c.name as constructorName')
            ->from('AppBundle:DriverStandings', 'ds')
            ->join('ds.driver', 'd')
            ->join('AppBundle:Constructor', 'c', Expr\Join::WITH, $builder->expr()->in(
                'c.id',
                $this->_em->createQueryBuilder()
                    ->select('c2.id')
                    ->from('AppBundle:Team', 't2')
                    ->join('t2.constructor', 'c2')
                    ->where($builder->expr()->eq('t2.season', ':year'))
                    ->andWhere($builder->expr()->eq('t2.driver', 'ds.driver'))
                    ->getDQL()
            ))
            ->join('ds.race', 'r', Expr\Join::WITH, $builder->expr()->eq('r.id', $race->getId()))
            ->addOrderBy($builder->expr()->asc('ds.position'))
            ->addOrderBy($builder->expr()->asc('ds.points'))
            ->addOrderBy($builder->expr()->asc('ds.wins'))
            ->setParameter(':year', $year)
        ;

        return $builder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(DriverStandings $driverStandings)
    {
        $this
            ->persist($driverStandings)
            ->flush()
        ;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(DriverStandings $driverStandings)
    {
        $this->_em->persist($driverStandings);

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

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $builder = $this->createQueryBuilder('ds');
        $builder
            ->join('ds.race', 'r')
            ->where($builder->expr()->eq('r.season', ':season'))
            ->setParameter(':season', $season)
        ;

        $entities = $builder->getQuery()->execute();

        foreach ($entities as $entity) {
            $this->_em->remove($entity);
        }

        $this->_em->flush();

        return $this;
    }
}
