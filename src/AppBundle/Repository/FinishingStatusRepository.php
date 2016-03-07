<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\FinishingStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The finishing status repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatusRepository extends EntityRepository implements FinishingStatusRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('s')
            ->from('AppBundle:FinishingStatus', 's', 's.label')
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function save(FinishingStatus $finishingStatus)
    {
        $this->_em->persist($finishingStatus);
        $this->_em->flush();
    }
}
