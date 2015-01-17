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

/**
 * The Constructor service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorService implements ConstructorServiceInterface
{
    /**
     * The Constructor repository.
     *
     * @var ConstructorRepositoryInterface
     */
    private $constructorRepository;

    /**
     * Constructor.
     *
     * @param ConstructorRepositoryInterface $constructorRepository A ConstructorRepositoryInterface instance
     */
    public function __construct(ConstructorRepositoryInterface $constructorRepository)
    {
        $this->constructorRepository = $constructorRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySLugs(array $slugs)
    {
        return $this->constructorRepository->findBySLugs($slugs);
    }
}
