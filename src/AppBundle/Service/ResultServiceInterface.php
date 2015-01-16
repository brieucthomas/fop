<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Result;

/**
 * The result service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ResultServiceInterface
{
    /**
     * Returns the number of wins of a constructor.
     *
     * @param string $constructorId A constructor identifier
     *
     * @return int The number of wins
     */
    public function countWinsByConstructor($constructorId);

    /**
     * Returns the number of wins of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of wins
     */
    public function countWinsByDriver($driverId);

    /**
     * Returns the number of podiums of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of podiums
     */
    public function countPodiumsByDriver($driverId);

    /**
     * Returns the number of scored points of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of podiums
     */
    public function countPointsByDriver($driverId);

    /**
     * Returns the number of fastest laps of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of fastest laps
     */
    public function countFastestLapsByDriver($driverId);

    /**
     * Returns the number of results of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of results
     */
    public function countResultsByDriver($driverId);

    /**
     * Returns the best finishing position of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The best finishing position
     */
    public function getBestPositionByDriver($driverId);
}
