<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Circuit;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Circuit service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface CircuitServiceInterface
{
    /**
     * Finds circuits by identifiers.
     *
     * @param array $ids An array of circuit identifiers
     *
     * @return ArrayCollection A collection of Circuit entities indexed by id
     */
    public function findByIds(array $ids);

    /**
     * Saves a circuit.
     *
     * @param Circuit $circuit The circuit to save
     *
     * @return $this
     */
    public function save(Circuit $circuit);

    /**
     * Persists a circuit.
     *
     * @param Circuit $circuit The circuit to persist
     *
     * return $this;
     */
    public function persist(Circuit $circuit);

    /**
     * Flushes modifications.
     *
     * return $this;
     */
    public function flush();
}
