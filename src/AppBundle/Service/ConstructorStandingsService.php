<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;
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
    public function removeBySeason(Season $season)
    {
        $this->constructorStandingsRepository->removeBySeason($season);

        return $this;
    }
}
