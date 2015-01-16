<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\FinishingStatus;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The FinishingStatus repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface FinishingStatusRepositoryInterface
{
    /**
     * Finds all finishing statuses.
     *
     * @return ArrayCollection A collection of FinishingStatus entities indexed by label
     */
    public function findAll();

    /**
     * Saves a finishingStatus.
     *
     * @param FinishingStatus $finishingStatus The finishingStatus to save
     *
     * @return $this
     */
    public function save(FinishingStatus $finishingStatus);

    /**
     * Persists a finishingStatus.
     *
     * @param FinishingStatus $finishingStatus The finishingStatus to persist
     *
     * return $this
     */
    public function persist(FinishingStatus $finishingStatus);

    /**
     * Flushes modifications.
     *
     * return $this
     */
    public function flush();
}
