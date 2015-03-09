<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\FinishingPosition;
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
        $builder = $this->createQueryBuilder('fp');
        $builder
            ->select('fp', 'r.position')
            ->join('fp.prediction', 'p')
            ->leftJoin(
                'AppBundle:Result',
                'r',
                Expr\Join::WITH,
                $builder->expr()->andX(
                    $builder->expr()->eq('r.race', 'p.race'),
                    $builder->expr()->eq('r.team', 'fp.team')
                )
            )
            ->join('p.race', 'race')
            ->where($builder->expr()->eq('race.season', ':season'))
            ->setParameter(':season', $year)
        ;

        $rows = $builder->getQuery()->getResult();

        foreach ($rows as $row) {
            /* @var $finishingPosition FinishingPosition */
            $finishingPosition = reset($row);
            $finishingPosition->setFinishingPosition(($row['position'] > 0)? $row['position'] : null);

            $this->_em->persist($finishingPosition);
        }

        $this->_em->flush();

        return $this;
    }
}
