<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Season;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Season repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface SeasonRepositoryInterface
{
    /**
     * Finds all years.
     *
     * @return ArrayCollection A collection of years
     */
    public function findYears();

    /**
     * Finds a season by its year.
     *
     * @param int $year The season year in 4 digits
     *
     * @return Season|null The Season entity or null if not found
     */
    public function findByYear($year);

    /**
     * Finds season by years.
     *
     * @param array $years An array of years
     *
     * @return ArrayCollection A collection of Season entities indexed by year
     */
    public function findByYears(array $years);

    /**
     * Returns the driver world championship years.
     *
     * @param string $driverId A driver identifier
     *
     * @return ArrayCollection A collection of years
     */
    public function getChampionshipsByDriver($driverId);

    /**
     * Returns the constructor world championship years.
     *
     * @param string $constructorId A constructor identifier
     *
     * @return ArrayCollection A collection of years
     */
    public function getConstructorsChampionshipsByConstructor($constructorId);

    /**
     * Returns the constructor world championship years.
     *
     * @param string $constructorId A constructor identifier
     *
     * @return ArrayCollection A collection of years
     */
    public function getDriversChampionshipsByConstructor($constructorId);

    /**
     * Returns the driver world championship positions by years.
     *
     * @param string $driverId A driver identifier
     *
     * @return array An array of positions and years
     */
    public function getChampionshipPositionsByDriver($driverId);

    /**
     * Saves a season.
     *
     * @param Season $season The season to save
     *
     * @return $this
     */
    public function save(Season $season);

    /**
     * Persists a season.
     *
     * @param Season $season The season to persist
     *
     * return $this
     */
    public function persist(Season $season);

    /**
     * Flushes modifications.
     *
     * return $this
     */
    public function flush();
}
