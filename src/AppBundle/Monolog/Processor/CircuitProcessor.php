<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Circuit;

/**
 * Injects circuit information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class CircuitProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['circuit'])) {
            return $record;
        }

        $circuit = $record['context']['circuit'];

        if (!$circuit instanceof Circuit) {
            return $record;
        }

        $record['context']['circuit'] = [
            'id' => $circuit->getId(),
            'name' => $circuit->getName(),
            'slug' => $circuit->getSlug(),
        ];

        return $record;
    }
}
