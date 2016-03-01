<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class FixtureLoader extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__.'/data/user.yml',
            __DIR__.'/data/scoringsystem.yml',
            __DIR__.'/data/season.yml',
            __DIR__.'/data/circuit.yml',
            __DIR__.'/data/race.yml',
            __DIR__.'/data/driver.yml',
            __DIR__.'/data/constructor.yml',
            __DIR__.'/data/team.yml',
            __DIR__.'/data/qualifying.yml',
            __DIR__.'/data/finishingstatus.yml',
            __DIR__.'/data/result.yml',
            __DIR__.'/data/prediction.yml',
            __DIR__.'/data/finishingposition.yml',
            __DIR__.'/data/driverstandings.yml',
            __DIR__.'/data/constructorstandings.yml',
            __DIR__.'/data/userstandings.yml',
        ];
    }
}
