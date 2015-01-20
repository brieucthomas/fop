<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Race;
use AppBundle\Entity\Result;
use AppBundle\Repository\RaceRepositoryInterface;

/**
 * The Race service.
 *
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
    public function addConstructorStandings(Race $race, ConstructorStandings $constructorStandings)
    {
        $race->addConstructorStandings($constructorStandings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addDriverStandings(Race $race, DriverStandings $driverStandings)
    {
        $race->addDriverStandings($driverStandings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addResult(Race $race, Result $result)
    {
        $race->addResult($result);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addQualifying(Race $race, Qualifying $qualifying)
    {
        $race->addQualifying($qualifying);

        return $this;
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
