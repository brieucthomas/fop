<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\FinishingStatus;
use AppBundle\Repository\FinishingStatusRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatusService implements FinishingStatusServiceInterface
{
    private $finishingStatusRepository;
    private $logger;

    public function __construct(FinishingStatusRepositoryInterface $finishingStatusRepository, LoggerInterface $logger)
    {
        $this->finishingStatusRepository = $finishingStatusRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->finishingStatusRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function save(FinishingStatus $finishingStatus)
    {
        $this->finishingStatusRepository->save($finishingStatus);
    }
}
