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

/**
 * The FinishingStatus service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatusService implements FinishingStatusServiceInterface
{
    /**
     * The FinishingStatus repository.
     *
     * @var FinishingStatusRepositoryInterface
     */
    private $finishingStatusRepository;

    /**
     * Constructor.
     *
     * @param FinishingStatusRepositoryInterface $finishingStatusRepository A FinishingStatusRepositoryInterface instance
     */
    public function __construct(FinishingStatusRepositoryInterface $finishingStatusRepository)
    {
        $this->finishingStatusRepository = $finishingStatusRepository;
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(FinishingStatus $finishingStatus)
    {
        $this->finishingStatusRepository->persist($finishingStatus);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->finishingStatusRepository->flush();

        return $this;
    }
}
