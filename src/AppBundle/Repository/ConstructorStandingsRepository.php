<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The constructor standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsRepository extends EntityRepository implements ConstructorStandingsRepositoryInterface
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

        $builder = $this->createQueryBuilder('cs');
        $builder
            ->join('cs.race', 'r', Expr\Join::WITH, $builder->expr()->eq('r.id', $race->getId()))
            ->addOrderBy($builder->expr()->asc('cs.position'))
            ->addOrderBy($builder->expr()->asc('cs.points'))
            ->addOrderBy($builder->expr()->asc('cs.wins'))
        ;

        return $builder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(ConstructorStandings $constructorStandings)
    {
        $this->_em->persist($constructorStandings);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $builder = $this->createQueryBuilder('cs');
        $builder
            ->join('cs.race', 'r')
            ->where($builder->expr()->eq('r.season', ':season'))
            ->setParameter(':season', $season);

        $entities = $builder->getQuery()->execute();

        foreach ($entities as $entity) {
            $this->_em->remove($entity);
        }

        $this->_em->flush();
    }
}
