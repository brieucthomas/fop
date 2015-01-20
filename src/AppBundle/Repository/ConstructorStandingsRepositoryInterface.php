<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Season;

/**
 * The constructor standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorStandingsRepositoryInterface
{
    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     *
     * @return $this
     */
    public function removeBySeason(Season $season);
}
