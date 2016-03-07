<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Season;
use AppBundle\Repository\QualifyingRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingService implements QualifyingServiceInterface
{
    private $qualifyingRepository;
    private $logger;

    public function __construct(QualifyingRepositoryInterface $qualifyingRepository, LoggerInterface $logger)
    {
        $this->qualifyingRepository = $qualifyingRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Qualifying $qualifying)
    {
        $this->qualifyingRepository->save($qualifying);
    }

    /**
     * {@inheritdoc}
     */
    public function countPolePositionsByDriver($driverId)
    {
        return $this->qualifyingRepository->countPolePositionsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBestGridByDriver($driverId)
    {
        return $this->qualifyingRepository->getBestGridByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->qualifyingRepository->removeBySeason($season);
    }
}
