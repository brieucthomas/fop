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

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceService implements RaceServiceInterface
{
    /**
     * The Race repository.
     *
     * @var RaceRepositoryInterface
     */
    private $raceRepository;

    /**
     * Constructor.
     *
     * @param RaceRepositoryInterface $raceRepository A RaceRepositoryInterface instance
     */
    public function __construct(RaceRepositoryInterface $raceRepository)
    {
        $this->raceRepository = $raceRepository;
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Race $race)
    {
        $this->raceRepository->persist($race);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->raceRepository->flush();

        return $this;
    }
}
