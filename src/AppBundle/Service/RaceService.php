<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Race;
use AppBundle\Repository\RaceRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceService implements RaceServiceInterface
{
    private $raceRepository;
    private $logger;

    public function __construct(RaceRepositoryInterface $raceRepository, LoggerInterface $logger)
    {
        $this->raceRepository = $raceRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findNextRace()
    {
        return $this->raceRepository->findNextRace();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRace()
    {
        return $this->raceRepository->findLastRace();
    }

    /**
     * {@inheritdoc}
     */
    public function findLastRaceWithResults()
    {
        return $this->raceRepository->findLastRaceWithResults();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Race $race)
    {
        $this->raceRepository->save($race);
    }
}
