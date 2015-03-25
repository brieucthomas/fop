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
 * The driver standings service.
 *
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
     *
     * @return $this
     */
    public function save(DriverStandings $driverStandings);

    /**
     * Persists a DriverStandings.
     *
     * @param DriverStandings $driverStandings The DriverStandings to persist
     *
     * return $this
     */
    public function persist(DriverStandings $driverStandings);

    /**
     * Flushes modifications.
     *
     * return $this
     */
    public function flush();

    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     *
     * @return $this
     */
    public function removeBySeason(Season $season);
}
