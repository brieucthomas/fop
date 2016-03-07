<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Constructor;

/**
 * Injects constructor information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['constructor'])) {
            return $record;
        }

        $constructor = $record['context']['constructor'];

        if (!$constructor instanceof Constructor) {
            return $record;
        }

        $record['context']['constructor'] = [
            'id' => $constructor->getId(),
            'slug' => $constructor->getSlug(),
        ];

        return $record;
    }
}
