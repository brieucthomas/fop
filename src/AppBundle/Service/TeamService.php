<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Repository\TeamRepositoryInterface;

/**
 * The Team service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TeamService implements TeamServiceInterface
{
    /**
     * The Team repository.
     *
     * @var TeamRepositoryInterface
     */
    private $teamRepository;

    /**
     * Constructor.
     *
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findByDriver($driverId)
    {
        return $this->teamRepository->findByDriver($driverId);
    }
}
