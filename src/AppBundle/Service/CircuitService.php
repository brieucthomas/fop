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

/**
 * The Circuit service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class CircuitService implements CircuitServiceInterface
{
    /**
     * The Circuit repository.
     *
     * @var CircuitRepositoryInterface
     */
    private $circuitRepository;

    /**
     * Constructor.
     *
     * @param CircuitRepositoryInterface $circuitRepository A CircuitRepositoryInterface instance
     */
    public function __construct(CircuitRepositoryInterface $circuitRepository)
    {
        $this->circuitRepository = $circuitRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlugs(array $slugs)
    {
        return $this->circuitRepository->findBySlugs($slugs);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Circuit $circuit)
    {
        $this->circuitRepository->save($circuit);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Circuit $circuit)
    {
        $this->circuitRepository->persist($circuit);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->circuitRepository->flush();

        return $this;
    }
}
