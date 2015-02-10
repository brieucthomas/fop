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

/**
 * The constructor standings service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsService implements ConstructorStandingsServiceInterface
{
    /**
     * The constructor standings repository.
     *
     * @var ConstructorRepositoryInterface
     */
    private $constructorStandingsRepository;

    /**
     * Constructor.
     *
     * @param ConstructorStandingsRepositoryInterface $constructorStandingsRepository
     */
    public function __construct(ConstructorStandingsRepositoryInterface $constructorStandingsRepository)
    {
        $this->constructorStandingsRepository = $constructorStandingsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ConstructorStandings $constructorStandings)
    {
        $this->constructorStandingsRepository->save($constructorStandings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(ConstructorStandings $constructorStandings)
    {
        $this->constructorStandingsRepository->persist($constructorStandings);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->constructorStandingsRepository->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBySeason(Season $season)
    {
        $this->constructorStandingsRepository->removeBySeason($season);

        return $this;
    }
}
