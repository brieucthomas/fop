<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Entity\Season;
use AppBundle\Repository\UserRepositoryInterface;
use AppBundle\Repository\UserStandingsRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserStandingsService implements UserStandingsServiceInterface
{
    private $userStandingsRepository;
    private $logger;

    public function __construct(UserStandingsRepositoryInterface $userStandingsRepository, LoggerInterface $logger)
    {
        $this->userStandingsRepository = $userStandingsRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->userStandingsRepository->findByYear($year);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->userStandingsRepository->removeBySeason($season);
    }
}
