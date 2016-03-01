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
        // get last race with results
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('r')
            ->from('AppBundle:Race', 'r')
            ->join('r.results', 'res')
            ->where($builder->expr()->eq('r.season', ':year'))
            ->orderBy($builder->expr()->desc('r.date'))
            ->setParameter(':year', $year)
            ->setMaxResults(1)
        ;
        $race = $builder->getQuery()->getOneOrNullResult();

        if (!$race) {
            return [];
        }

        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('ds.position', 'ds.points', 'ds.wins', 'd.firstName', 'd.lastName', 'd.nationality', 'd.code', 'c.slug as constructorSlug', 'c.name as constructorName')
            ->from('AppBundle:DriverStandings', 'ds')
            ->join('ds.race', 'r', Expr\Join::WITH, $builder->expr()->eq('r.id', $race->getId()))
            ->join('AppBundle:Team', 't', Expr\Join::WITH, $builder->expr()->andX($builder->expr()->eq('t.season', ':year'), $builder->expr()->eq('t.driver', 'ds.driver')))
            ->join('t.driver', 'd')
            ->join('t.constructor', 'c')
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
