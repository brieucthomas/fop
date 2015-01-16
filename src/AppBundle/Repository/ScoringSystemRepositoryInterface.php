<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\ScoringSystem;

/**
 * The ScoringSystem repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ScoringSystemRepositoryInterface
{
    /**
     * Finds the default scoring system.
     *
     * @return ScoringSystem
     */
    public function findByDefault();
}
