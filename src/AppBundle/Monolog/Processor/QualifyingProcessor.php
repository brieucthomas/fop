<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Circuit;
use AppBundle\Entity\Qualifying;

/**
 * Injects qualifying information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['qualifying'])) {
            return $record;
        }

        $qualifying = $record['context']['qualifying'];

        if (!$qualifying instanceof Qualifying) {
            return $record;
        }

        $record['context']['qualifying'] = [
            'race' => $qualifying->getRace()->getName(),
            'position' => $qualifying->getPosition(),
            'driver' => $qualifying->getTeam()->getDriver()->getName()
        ];

        return $record;
    }
}
