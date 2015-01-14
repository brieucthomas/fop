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
 * The Driver service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverService implements DriverServiceInterface
{
    /**
     * The Driver repository.
     *
     * @var DriverRepositoryInterface
     */
    private $driverRepository;

    /**
     * Constructor.
     *
     * @param DriverRepositoryInterface $driverRepository A DriverRepositoryInterface instance
     */
    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(array $ids)
    {
        return $this->driverRepository->findByIds($ids);
    }
}
