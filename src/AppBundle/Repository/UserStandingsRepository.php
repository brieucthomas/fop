<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;

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

        return $this;
    }
}
