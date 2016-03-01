<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Repository\DriverRepositoryInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverService implements DriverServiceInterface
{
    private $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug($slug)
    {
        return $this->driverRepository->findBySlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlugs(array $slugs)
    {
        return $this->driverRepository->findBySlugs($slugs);
    }
}
