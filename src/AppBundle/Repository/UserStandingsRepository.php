<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Season;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The user standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserStandingsRepository extends EntityRepository implements UserStandingsRepositoryInterface
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

        $builder = $this->createQueryBuilder('us');
        $builder
            ->join('us.race', 'r', Expr\Join::WITH, $builder->expr()->eq('r.id', $race->getId()))
            ->addOrderBy($builder->expr()->asc('us.position'))
            ->addOrderBy($builder->expr()->asc('us.points'))
            ->addOrderBy($builder->expr()->asc('us.wins'))
        ;

        return $builder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $builder = $this->createQueryBuilder('us');
        $builder
            ->join('us.race', 'r')
            ->where($builder->expr()->eq('r.season', ':season'))
            ->setParameter(':season', $season)
        ;

        $entities = $builder->getQuery()->execute();

        foreach ($entities as $entity) {
            $this->_em->remove($entity);
        }

        $this->_em->flush();
    }
}
