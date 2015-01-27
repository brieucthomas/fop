<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Season;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The season repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonRepository extends EntityRepository implements SeasonRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findYears()
    {
        $builder = $this->createQueryBuilder('s');
        $builder
            ->select('s.year')
            ->orderBy($builder->expr()->asc('s.year'))
        ;

        $result = $builder->getQuery()->getResult();

        return new ArrayCollection(array_map('current', $result));
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->find($year);
    }

    /**
     * {@inheritdoc}
     */
    public function findByYears(array $years)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('s')
            ->from('AppBundle:Season', 's', 's.year')
            ->where($builder->expr()->eq('s.year', ':years'))
            ->setParameter(':years', $years)
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function getChampionshipsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('s');
        $builder
            ->select('s.year')
            ->join('s.races', 'r')
            ->join('r.driverStandings', 'd')
            ->where($builder->expr()->in(
                'r.round',
                $this->_em->createQueryBuilder()
                    ->select($builder->expr()->max('r2.round'))
                    ->from('AppBundle:Race', 'r2')
                    ->where($builder->expr()->eq('r2.season', 's'))
                    ->getDQL()
            ))
            ->andWhere($builder->expr()->eq('d.driver', ':driver'))
            ->andWhere($builder->expr()->eq('d.position', ':position'))
            ->setParameter(':driver', $driverId)
            ->setParameter(':position', 1)
            ->orderBy($builder->expr()->asc('s.year'))
        ;

        $result = $builder->getQuery()->getResult();

        return new ArrayCollection(array_map('current', $result));
    }

    /**
     * {@inheritdoc}
     */
    public function getConstructorsChampionshipsByConstructor($constructorId)
    {
        $builder = $this->createQueryBuilder('s');
        $builder
            ->select('s.year')
            ->join('s.races', 'r')
            ->join('r.constructorStandings', 'c')
            ->where($builder->expr()->in(
                'r.round',
                $this->_em->createQueryBuilder()
                    ->select($builder->expr()->max('r2.round'))
                    ->from('AppBundle:Race', 'r2')
                    ->where($builder->expr()->eq('r2.season', 's'))
                    ->getDQL()
            ))
            ->andWhere($builder->expr()->eq('c.constructor', ':constructor'))
            ->andWhere($builder->expr()->eq('c.position', ':position'))
            ->setParameter(':constructor', $constructorId)
            ->setParameter(':position', 1)
            ->orderBy($builder->expr()->asc('s.year'))
        ;

        $result = $builder->getQuery()->getResult();

        return new ArrayCollection(array_map('current', $result));
    }

    /**
     * {@inheritdoc}
     */
    public function getDriversChampionshipsByConstructor($constructorId)
    {
        $builder = $this->createQueryBuilder('s');
        $builder
            ->select('s.year')
            ->join('s.races', 'r')
            ->join('r.driverStandings', 'd')
            ->join('s.teams', 't')
            ->where($builder->expr()->in(
                'r.round',
                $this->_em->createQueryBuilder()
                    ->select($builder->expr()->max('r2.round'))
                    ->from('AppBundle:Race', 'r2')
                    ->where($builder->expr()->eq('r2.season', 's'))
                    ->getDQL()
            ))
            ->andWhere($builder->expr()->eq('t.driver', 'd.driver'))
            ->andWhere($builder->expr()->eq('d.position', ':position'))
            ->andWhere($builder->expr()->eq('t.constructor', ':constructor'))
            ->setParameter(':position', 1)
            ->setParameter(':constructor', $constructorId)
            ->orderBy($builder->expr()->asc('s.year'))
        ;

        $result = $builder->getQuery()->getResult();

        return new ArrayCollection(array_map('current', $result));
    }

    /**
     * {@inheritdoc}
     */
    public function getChampionshipPositionsByDriver($driverId)
    {
        $builder = $this->createQueryBuilder('s');
        $builder
            ->select('s.year', 'd.position')
            ->join('s.races', 'r')
            ->join('r.driverStandings', 'd')
            ->where($builder->expr()->in(
                'r.round',
                $this->_em->createQueryBuilder()
                    ->select($builder->expr()->max('r2.round'))
                    ->from('AppBundle:Race', 'r2')
                    ->where($builder->expr()->eq('r2.season', 's'))
                    ->getDQL()
            ))
            ->andWhere($builder->expr()->eq('d.driver', ':driver'))
            ->setParameter(':driver', $driverId)
            ->orderBy($builder->expr()->asc('s.year'))
        ;

        return $builder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Season $season)
    {
        $this
            ->persist($season)
            ->flush()
        ;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Season $season)
    {
        $this->_em->persist($season);

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
