<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Season;

/**
 * The driver standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface DriverStandingsRepositoryInterface
{
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
