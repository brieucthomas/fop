<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;

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
    public function removeBySeason(Season $season)
    {
        $builder = $this->createQueryBuilder('cs');
        $builder
            ->join('cs.race', 'r')
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
