<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Season;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface QualifyingServiceInterface
{
    /**
     * Saves a qualifying.
     *
     * @param Qualifying $qualifying The qualifying to save
     *
     * @return $this
     */
    public function save(Qualifying $qualifying);

    /**
     * Persists a qualifying.
     *
     * @param Qualifying $qualifying The qualifying to persist
     *
     * return $this
     */
    public function persist(Qualifying $qualifying);

    /**
     * Flushes modifications.
     *
     * return $this
     */
    public function flush();

    /**
     * Returns the number of pole positions of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of pole positions
     */
    public function countPolePositionsByDriver($driverId);

    /**
     * Returns the best grid position of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The best grid position
     */
    public function getBestGridByDriver($driverId);

    /**
     * Removes qualifying by season.
     *
     * @param Season $season A Season entity
     *
     * @return $this
     */
    public function removeBySeason(Season $season);
}
