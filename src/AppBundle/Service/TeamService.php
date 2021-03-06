<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\Driver;
use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use AppBundle\Repository\TeamRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TeamService implements TeamServiceInterface
{
    private $teamRepository;
    private $logger;

    public function __construct(TeamRepositoryInterface $teamRepository, LoggerInterface $logger)
    {
        $this->teamRepository = $teamRepository;
        $this->logger = $logger;
    }

    public function findBySeasonAndDriverAndConstructor(Season $season, Driver $driver, Constructor $constructor)
    {
        return $this->teamRepository->findBySeasonAndDriverAndConstructor($season, $driver, $constructor);
    }

    /**
     * {@inheritdoc}
     */
    public function findByDriver($driverId)
    {
        return $this->teamRepository->findByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Team $team)
    {
        $this->teamRepository->save($team);
    }
}
