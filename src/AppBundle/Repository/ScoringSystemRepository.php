<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\ScoringSystem;
use Doctrine\ORM\EntityRepository;

/**
 * The ScoringSystem repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ScoringSystemRepository extends EntityRepository implements ScoringSystemRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByDefault()
    {
        return $this->findOneBy(['isDefault' => true]);
    }
}
