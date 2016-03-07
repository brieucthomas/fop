<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Season;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface DriverStandingsServiceInterface
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
     * Saves a DriverStandings.
     *
     * @param DriverStandings $driverStandings The DriverStandings to save
     */
    public function save(DriverStandings $driverStandings);

    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     */
    public function removeBySeason(Season $season);
}
