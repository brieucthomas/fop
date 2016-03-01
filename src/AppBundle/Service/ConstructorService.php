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
use Nelmio\Alice\Instances\Collection;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorService implements ConstructorServiceInterface
{
    private $constructorRepository;

    public function __construct(ConstructorRepositoryInterface $constructorRepository)
    {
        $this->constructorRepository = $constructorRepository;
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
    public function findBySlugs(array $slugs) : Collection
    {
        return $this->constructorRepository->findBySLugs($slugs);
    }
}
