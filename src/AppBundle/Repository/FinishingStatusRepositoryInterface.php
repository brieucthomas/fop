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
 * The finishing status repository.
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
     */
    public function save(FinishingStatus $finishingStatus);
}
