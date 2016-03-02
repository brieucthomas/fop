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
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class CircuitService implements CircuitServiceInterface
{
    private $circuitRepository;
    private $logger;

    public function __construct(CircuitRepositoryInterface $circuitRepository, LoggerInterface $logger)
    {
        $this->circuitRepository = $circuitRepository;
        $this->logger = $logger;
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
        $this->logger->notice($circuit->getId() ? 'Edit circuit.' : 'New circuit.', ['circuit' => $circuit]);

        $this->circuitRepository->save($circuit);
    }
}
