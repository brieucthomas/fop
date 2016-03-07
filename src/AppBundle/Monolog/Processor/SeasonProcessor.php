<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Season;

/**
 * Injects season information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['season'])) {
            return $record;
        }

        $season = $record['context']['season'];

        if (!$season instanceof Season) {
            return $record;
        }

        $record['context']['season'] = [
            'year' => $season->getYear(),
        ];

        return $record;
    }
}
