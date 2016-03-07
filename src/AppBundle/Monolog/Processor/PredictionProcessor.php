<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Prediction;

/**
 * Injects prediction information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['prediction'])) {
            return $record;
        }

        $prediction = $record['context']['prediction'];

        if (!$prediction instanceof Prediction) {
            return $record;
        }

        $record['context']['prediction'] = [
            'id' => $prediction->getId(),
            'user' => $prediction->getUser()->getSlug(),
            'season' => $prediction->getRace()->getSeason()->getYear(),
            'round' => $prediction->getRace()->getRound(),
        ];

        return $record;
    }
}
