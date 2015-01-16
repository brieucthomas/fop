<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\UserStandings;
use AppBundle\Repository\ScoringSystemRepository;
use AppBundle\Repository\ScoringSystemRepositoryInterface;
use AppBundle\Repository\SeasonRepositoryInterface;
use AppBundle\Repository\UserRepositoryInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * The Season service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonService implements SeasonServiceInterface
{
    /**
     * The Season repository.
     *
     * @var SeasonRepositoryInterface
     */
    private $seasonRepository;

    /**
     * The ScoringSystem repository.
     *
     * @var ScoringSystemRepositoryInterface
     */
    private $scoringSystemRepository;

    /**
     * The user repository.
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Constructor.
     *
     * @param SeasonRepositoryInterface        $seasonRepository        A SeasonRepositoryInterface instance
     * @param ScoringSystemRepositoryInterface $scoringSystemRepository A ScoringSystemRepositoryInterface instance
     * @param UserRepositoryInterface          $userRepository
     */
    public function __construct(
        SeasonRepositoryInterface $seasonRepository,
        ScoringSystemRepositoryInterface $scoringSystemRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->seasonRepository = $seasonRepository;
        $this->scoringSystemRepository = $scoringSystemRepository;
        $this->userRepository = $userRepository;
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addRace(Season $season, Race $race)
    {
        $season->addRace($race);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTeam(Season $season, Team $team)
    {
        $season->addTeam($team);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function computePredictions(Season $season)
    {
        $season->computePredictionsPoints();

        $users = $this->userRepository->findByYear($season->getYear());

        /* @var $previousRace Race */
        $previousRace = null;

        foreach ($season->getRaces() as $race) {
            /* @var $race Race */
            foreach ($users as $user) {
                /* @var $user User */
                if ($previousRace) {
                    $userStanding = clone $previousRace->getUserStandingsByUser($user);
                } else {
                    $userStanding = new UserStandings();
                    $userStanding->setUser($user);
                }

                $race->addUserStanding($userStanding);

                $prediction = $race->getPredictionByUser($user);

                if ($prediction) {
                    $userStanding->addPoints($prediction->getPoints());

                    if ($prediction->isWin()) {
                        $userStanding->increaseWins();
                    }
                } else {
                    $userStanding->addPoints($race->getBonus());
                }
            }

            $userStandings = $race->getUserStandings()->matching(
                Criteria::create()->orderBy(['points' => Criteria::DESC])
            );

            $position = 0;
            foreach ($userStandings as $userStanding) {
                /* @var $userStanding UserStandings */
                $userStanding->setPosition(++$position);
            }

            $race->setUserStandings($userStandings);

            $previousRace = $race;
        }

        $this->save($season);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Season $season)
    {
        $this->seasonRepository->persist($season);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->seasonRepository->flush();

        return $this;
    }
}
