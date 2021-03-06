<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Race;

/**
 * The race repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface RaceRepositoryInterface
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
     */
    public function save(Race $race);
}
