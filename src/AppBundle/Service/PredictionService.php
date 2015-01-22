<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Repository\FinishingPositionRepositoryInterface;
use AppBundle\Repository\PredictionRepositoryInterface;

/**
 * The prediction service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionService implements PredictionServiceInterface
{
    /**
     * @var PredictionRepositoryInterface
     */
    private $predictionRepository;

    /**
     * @var FinishingPositionRepositoryInterface
     */
    private $finishingPositionRepository;

    /**
     * Constructor.
     *
     * @param PredictionRepositoryInterface        $predictionRepository
     * @param FinishingPositionRepositoryInterface $finishingPositionRepository
     */
    public function __construct(PredictionRepositoryInterface $predictionRepository, FinishingPositionRepositoryInterface $finishingPositionRepository)
    {
        $this->predictionRepository = $predictionRepository;
        $this->finishingPositionRepository = $finishingPositionRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFinishingPositionsByYear($year)
    {
        $this->finishingPositionRepository->updateFinishingPositionsByYear($year);

        return $this;
    }
}
