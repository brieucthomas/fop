<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\Season;
use AppBundle\Repository\DriverRepositoryInterface;
use AppBundle\Repository\DriverStandingsRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandingsService implements DriverStandingsServiceInterface
{
    private $driverStandingsRepository;
    private $logger;

    public function __construct(DriverStandingsRepositoryInterface $driverStandingsRepository, LoggerInterface $logger)
    {
        $this->driverStandingsRepository = $driverStandingsRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->driverStandingsRepository->findByYear($year);
    }

    /**
     * {@inheritdoc}
     */
    public function save(DriverStandings $driverStandings)
    {
        $this->driverStandingsRepository->save($driverStandings);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->driverStandingsRepository->removeBySeason($season);
    }
}
