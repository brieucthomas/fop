<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
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
    public function removeBySeason(Season $season)
    {
        $this->driverStandingsRepository->removeBySeason($season);

        return $this;
    }
}
