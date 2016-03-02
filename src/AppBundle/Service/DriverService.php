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
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverService implements DriverServiceInterface
{
    private $driverRepository;
    private $logger;

    public function __construct(DriverRepositoryInterface $driverRepository, LoggerInterface $logger)
    {
        $this->driverRepository = $driverRepository;
        $this->logger = $logger;
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

    /**
     * {@inheritdoc}
     */
    public function save(Driver $driver)
    {
        $this->logger->notice($driver->getId() ? 'Edit driver.' : 'New driver.', ['driver' => $driver]);

        $this->driverRepository->save($driver);
    }
}
