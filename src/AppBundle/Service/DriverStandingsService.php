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

/**
 * The driver standings service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandingsService implements DriverStandingsServiceInterface
{
    /**
     * The driver standings repository.
     *
     * @var DriverRepositoryInterface
     */
    private $driverStandingsRepository;

    /**
     * Constructor.
     *
     * @param DriverStandingsRepositoryInterface $driverStandingsRepository
     */
    public function __construct(DriverStandingsRepositoryInterface $driverStandingsRepository)
    {
        $this->driverStandingsRepository = $driverStandingsRepository;
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(DriverStandings $driverStandings)
    {
        $this->driverStandingsRepository->persist($driverStandings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->driverStandingsRepository->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->driverStandingsRepository->removeBySeason($season);

        return $this;
    }
}
