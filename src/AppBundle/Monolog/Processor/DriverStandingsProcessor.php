<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\DriverStandings;

/**
 * Injects driver standings information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandingsProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['driverStandings'])) {
            return $record;
        }

        $driverStandings = $record['context']['driverStandings'];

        if (!$driverStandings instanceof DriverStandings) {
            return $record;
        }

        $record['context']['driverStandings'] = [
            'season' => $driverStandings->getRace()->getSeason()->getYear(),
            'round' => $driverStandings->getRace()->getRound(),
            'position' => $driverStandings->getPosition(),
            'driver' => $driverStandings->getDriver()->getSlug(),
            'points' => $driverStandings->getPoints(),
        ];

        return $record;
    }
}
