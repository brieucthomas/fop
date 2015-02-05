<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\Season;

/**
 * The constructor standings repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorStandingsRepositoryInterface
{
    /**
     * Saves a ConstructorStandings.
     *
     * @param ConstructorStandings $constructorStandings The ConstructorStandings to save
     *
     * @return $this
     */
    public function save(ConstructorStandings $constructorStandings);

    /**
     * Persists a ConstructorStandings.
     *
     * @param ConstructorStandings $constructorStandings The ConstructorStandings to persist
     *
     * return $this
     */
    public function persist(ConstructorStandings $constructorStandings);

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
