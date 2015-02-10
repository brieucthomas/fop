<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Race;

/**
 * The race service.
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
