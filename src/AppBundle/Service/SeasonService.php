<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Race;
use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use AppBundle\Repository\ScoringSystemRepositoryInterface;
use AppBundle\Repository\SeasonRepositoryInterface;
use AppBundle\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonService implements SeasonServiceInterface
{
    private $seasonRepository;
    private $scoringSystemRepository;
    private $userRepository;
    private $logger;

    public function __construct(
        SeasonRepositoryInterface $seasonRepository,
        ScoringSystemRepositoryInterface $scoringSystemRepository,
        UserRepositoryInterface $userRepository,
        LoggerInterface $logger
    ) {
        $this->seasonRepository = $seasonRepository;
        $this->scoringSystemRepository = $scoringSystemRepository;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findYears()
    {
        return $this->seasonRepository->findYears();
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->seasonRepository->findByYear($year);
    }

    /**
     * {@inheritdoc}
     */
    public function findByYears(array $years)
    {
        return $this->seasonRepository->findByYears($years);
    }

    /**
     * {@inheritdoc}
     */
    public function getChampionshipsByDriver($driverId)
    {
        return $this->seasonRepository->getChampionshipsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function getConstructorsChampionshipsByConstructor($constructorId)
    {
        return $this->seasonRepository->getConstructorsChampionshipsByConstructor($constructorId);
    }

    /**
     * {@inheritdoc}
     */
    public function getDriversChampionshipsByConstructor($constructorId)
    {
        return $this->seasonRepository->getDriversChampionshipsByConstructor($constructorId);
    }

    /**
     * {@inheritdoc}
     */
    public function getChampionshipPositionsByDriver($driverId)
    {
        return $this->seasonRepository->getChampionshipPositionsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function create($year)
    {
        $scoringSystem = $this->scoringSystemRepository->findByDefault();

        $season = new Season($year);
        $season->setScoringSystem($scoringSystem);

        $this->save($season);

        return $season;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Season $season)
    {
        $this->seasonRepository->save($season);
    }

    /**
     * {@inheritdoc}
     */
    public function addRace(Season $season, Race $race)
    {
        $season->addRace($race);
    }

    /**
     * {@inheritdoc}
     */
    public function addTeam(Season $season, Team $team)
    {
        $team->setSeason($season);
    }
}
