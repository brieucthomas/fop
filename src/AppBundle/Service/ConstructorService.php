<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
use AppBundle\Repository\ConstructorRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorService implements ConstructorServiceInterface
{
    private $constructorRepository;
    private $logger;

    public function __construct(ConstructorRepositoryInterface $constructorRepository, LoggerInterface $logger)
    {
        $this->constructorRepository = $constructorRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug($slug)
    {
        return $this->constructorRepository->findBySlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Constructor $constructor)
    {
        $this->constructorRepository->save($constructor);
    }
}
