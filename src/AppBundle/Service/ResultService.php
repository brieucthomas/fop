<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Result;
use AppBundle\Entity\Season;
use AppBundle\Repository\ResultRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ResultService implements ResultServiceInterface
{
    private $resultRepository;
    private $logger;

    public function __construct(ResultRepositoryInterface $resultRepository, LoggerInterface $logger)
    {
        $this->resultRepository = $resultRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Result $result)
    {
        $this->resultRepository->save($result);
    }

    /**
     * {@inheritdoc}
     */
    public function countWinsByConstructor($constructorId)
    {
        return $this->resultRepository->countWinsByConstructor($constructorId);
    }

    /**
     * {@inheritdoc}
     */
    public function countWinsByDriver($driverId)
    {
        return $this->resultRepository->countWinsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function countPodiumsByDriver($driverId)
    {
        return $this->resultRepository->countPodiumsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function countPointsByDriver($driverId)
    {
        return $this->resultRepository->countPointsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function countFastestLapsByDriver($driverId)
    {
        return $this->resultRepository->countFastestLapsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function countResultsByDriver($driverId)
    {
        return $this->resultRepository->countResultsByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBestPositionByDriver($driverId)
    {
        return $this->resultRepository->getBestPositionByDriver($driverId);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->resultRepository->removeBySeason($season);
    }
}
