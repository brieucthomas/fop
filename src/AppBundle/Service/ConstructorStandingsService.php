<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\Season;
use AppBundle\Repository\ConstructorRepositoryInterface;
use AppBundle\Repository\ConstructorStandingsRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsService implements ConstructorStandingsServiceInterface
{
    private $constructorStandingsRepository;
    private $logger;

    public function __construct(ConstructorStandingsRepositoryInterface $constructorStandingsRepository, LoggerInterface $logger)
    {
        $this->constructorStandingsRepository = $constructorStandingsRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->constructorStandingsRepository->findByYear($year);
    }

    /**
     * {@inheritdoc}
     */
    public function save(ConstructorStandings $constructorStandings)
    {
        $this->constructorStandingsRepository->save($constructorStandings);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->constructorStandingsRepository->removeBySeason($season);
    }
}
