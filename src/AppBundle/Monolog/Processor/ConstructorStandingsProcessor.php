<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\ConstructorStandings;

/**
 * Injects constructor standings information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['constructorStandings'])) {
            return $record;
        }

        $constructorStandings = $record['context']['constructorStandings'];

        if (!$constructorStandings instanceof ConstructorStandings) {
            return $record;
        }

        $record['context']['constructorStandings'] = [
            'season' => $constructorStandings->getRace()->getSeason()->getYear(),
            'round' => $constructorStandings->getRace()->getRound(),
            'position' => $constructorStandings->getPosition(),
            'constructor' => $constructorStandings->getConstructor()->getSlug(),
            'points' => $constructorStandings->getPoints(),
        ];

        return $record;
    }
}
