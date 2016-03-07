<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\Season;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorStandingsServiceInterface
{
    /**
     * Returns the constructor standings by year.
     *
     * @param int $year A year
     *
     * @return array
     */
    public function findByYear($year);

    /**
     * Saves a ConstructorStandings.
     *
     * @param ConstructorStandings $constructorStandings The ConstructorStandings to save
     */
    public function save(ConstructorStandings $constructorStandings);

    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     */
    public function removeBySeason(Season $season);
}
