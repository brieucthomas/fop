<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity\Season;

/**
 * The circuit loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface LoaderInterface
{
    /**
     * Loads data.
     *
     * @param Season $season
     *
     * @return void
     */
    public function load(Season $season);
}
