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
 * The user standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface UserStandingsRepositoryInterface
{
    /**
     * Returns the driver standings by year.
     *
     * @param int $year A year
     *
     * @return array
     */
    public function findByYear($year);

    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     */
    public function removeBySeason(Season $season);
}
