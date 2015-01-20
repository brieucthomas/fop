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

/**
 * The user standings service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserStandingsService implements UserStandingsServiceInterface
{
    /**
     * The user standings repository.
     *
     * @var UserRepositoryInterface
     */
    private $userStandingsRepository;

    /**
     * Constructor.
     *
     * @param UserStandingsRepositoryInterface $userStandingsRepository
     */
    public function __construct(UserStandingsRepositoryInterface $userStandingsRepository)
    {
        $this->userStandingsRepository = $userStandingsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->userStandingsRepository->removeBySeason($season);

        return $this;
    }
}
