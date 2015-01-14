<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Constructor service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorServiceInterface
{
    /**
     * Finds constructors by identifiers.
     *
     * @param array $ids An array of constructor identifiers
     *
     * @return ArrayCollection A collection of Constructor entities indexed by id
     */
    public function findByIds(array $ids);
}
