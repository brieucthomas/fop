<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The finishing position repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingPositionRepository extends EntityRepository implements FinishingPositionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function updateFinishingPositionsByYear($year)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->update($this->_entityName, 'fp')
            ->join('fp.prediction', 'p')
            ->join('p.race', 'race')
            ->join('AppBundle:Result', 'result', Expr\Join::WITH, $builder->expr()->eq('result.race', 'p.race'))
            ->set('fp.finishingPosition', 'r.position')
            ->where($builder->expr()->eq('r.team', 'fp.team'))
            ->where($builder->expr()->eq('race.season', ':season'))
            ->setParameter(':season', $year)
        ;

        $builder->getQuery()->execute();

        return $this;
    }
}
