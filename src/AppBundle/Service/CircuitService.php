<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Circuit;
use AppBundle\Repository\CircuitRepositoryInterface;
use Doctrine\Common\Collections\Collection;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class CircuitService implements CircuitServiceInterface
{
    private $circuitRepository;

    public function __construct(CircuitRepositoryInterface $circuitRepository)
    {
        $this->circuitRepository = $circuitRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlugs(array $slugs) : Collection
    {
        return $this->circuitRepository->findBySlugs($slugs);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Circuit $circuit)
    {
        $this->circuitRepository->save($circuit);
    }
}
