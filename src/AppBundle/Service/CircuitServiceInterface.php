<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Circuit;
use Doctrine\Common\Collections\Collection;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface CircuitServiceInterface
{
    /**
     * Finds circuits by slugs.
     *
     * @param array $slugs An array of circuit slugs
     *
     * @return Collection A collection of Circuit entities indexed by slug
     */
    public function findBySlugs(array $slugs) : Collection;

    /**
     * Saves a circuit.
     *
     * @param Circuit $circuit The circuit to save
     */
    public function save(Circuit $circuit);
}
