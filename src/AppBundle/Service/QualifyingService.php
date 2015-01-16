<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Qualifying;
use AppBundle\Repository\QualifyingRepositoryInterface;

/**
 * The qualifying service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingService implements QualifyingServiceInterface
{
    /**
     * The qualifying repository.
     *
     * @var QualifyingRepositoryInterface
     */
    private $qualifyingRepository;

    /**
     * Constructor.
     *
     * @param QualifyingRepositoryInterface $qualifyingRepository
     */
    public function __construct(QualifyingRepositoryInterface $qualifyingRepository)
    {
        $this->qualifyingRepository = $qualifyingRepository;
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
}
