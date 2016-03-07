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
use AppBundle\Entity\User;
use AppBundle\Entity\UserStandings;
use AppBundle\Repository\FinishingPositionRepositoryInterface;
use AppBundle\Repository\PredictionRepositoryInterface;
use AppBundle\Repository\SeasonRepositoryInterface;
use AppBundle\Repository\UserRepositoryInterface;
use AppBundle\Repository\UserStandingsRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionService implements PredictionServiceInterface
{
    private $em;
    private $predictionRepository;
    private $finishingPositionRepository;
    private $seasonRepository;
    private $userRepository;
    private $userStandingsRepository;
    private $logger;

    public function __construct(
        EntityManagerInterface $em,
        PredictionRepositoryInterface $predictionRepository,
        FinishingPositionRepositoryInterface $finishingPositionRepository,
        SeasonRepositoryInterface $seasonRepository,
        UserRepositoryInterface $userRepository,
        UserStandingsRepositoryInterface $userStandingsRepository,
        LoggerInterface $logger
    ) {
        $this->em = $em;
        $this->predictionRepository = $predictionRepository;
        $this->finishingPositionRepository = $finishingPositionRepository;
        $this->seasonRepository = $seasonRepository;
        $this->userRepository = $userRepository;
        $this->userStandingsRepository = $userStandingsRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findByRaceAndUser(Race $race, User $user)
    {
        return $this->predictionRepository->findByRaceAndUser($race, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Prediction $prediction)
    {
        $this->em->beginTransaction();

        try {
            $this->predictionRepository->remove($prediction);
            $this->predictionRepository->save($prediction);
            $this->em->commit();
        } catch (\Exception $failure) {
            $this->em->rollback();
            throw $failure;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function computeBySeason(Season $season)
    {
        $this->em->beginTransaction();

        try {
            // remove previous user standings
            $this->userStandingsRepository->removeBySeason($season);

            // update the finishing positions of predictions
            $this->finishingPositionRepository->updateFinishingPositionsByYear($season->getYear());

            // computes the season predictions points
            $season->computePredictionsPoints();

            // find the season players
            $users = $this->userRepository->findByYear($season->getYear());

            /* @var $previousRace Race */
            $previousRace = null;

            foreach ($season->getRacesWithResults() as $race) {
                /* @var $race Race */
                foreach ($users as $user) {
                    /* @var $user User */
                    if ($previousRace) {
                        $userStanding = clone $previousRace->getUserStandingsByUser($user);
                    } else {
                        $userStanding = new UserStandings();
                        $userStanding->setUser($user);
                    }

                    $race->addUserStandings($userStanding);

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

            $this->seasonRepository->save($season);
            $this->em->commit();
        } catch (\Exception $failure) {
            $this->em->rollback();
            throw $failure;
        }
    }
}
