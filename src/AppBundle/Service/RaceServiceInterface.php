<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Race;
use AppBundle\Entity\Result;

/**
 * The Race service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface RaceServiceInterface
{
    /**
     * Loads the next race.
     *
     * @return Race|null The race entity or null if not found
     */
    public function findNextRace();

    /**
     * Loads the previous race.
     *
     * @return Race|null The race entity or null if not found
     */
    public function findLastRace();

    /**
     * Returns the last race with results.
     *
     * @return Race|null The race entity or null if not found
     */
    public function findLastRaceWithResults();

    /**
     * Adds a constructor standings to a race.
     *
     * @param Race                 $race                 A Race entity
     * @param ConstructorStandings $constructorStandings A ConstructorStandings entity
     *
     * @return $this
     */
    public function addConstructorStandings(Race $race, ConstructorStandings $constructorStandings);

    /**
     * Adds a driver standings to a race.
     *
     * @param Race            $race            A Race entity
     * @param DriverStandings $driverStandings A ConstructorStandings entity
     *
     * @return $this
     */
    public function addDriverStandings(Race $race, DriverStandings $driverStandings);

    /**
     * Adds a result to a race.
     *
     * @param Race   $race   A Race entity
     * @param Result $result A Result entity
     *
     * @return $this
     */
    public function addResult(Race $race, Result $result);

    /**
     * Adds a qualifying to a race.
     *
     * @param Race       $race       A Race entity
     * @param Qualifying $qualifying A Qualifying entity
     *
     * @return $this
     */
    public function addQualifying(Race $race, Qualifying $qualifying);

    /**
     * Saves a race.
     *
     * @param Race $race The race to save
     *
     * @return $this
     */
    public function save(Race $race);

    /**
     * Persists a race.
     *
     * @param Race $race The race to persist
     *
     * return $this;
     */
    public function persist(Race $race);

    /**
     * Flushes modifications.
     *
     * return $this;
     */
    public function flush();
}
