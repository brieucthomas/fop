<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast;

use AppBundle\Ergast\Loader\LoaderInterface;
use AppBundle\Service\SeasonServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * The ergast importer.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Importer
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SeasonServiceInterface
     */
    private $seasonService;

    /**
     * @var array
     */
    private $loaders = [];

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em
     * @param SeasonServiceInterface $seasonService
     */
    public function __construct(EntityManagerInterface $em, SeasonServiceInterface $seasonService)
    {
        $this->em = $em;
        $this->seasonService = $seasonService;
    }

    /**
     * Adds an handler.
     *
     * @param LoaderInterface $loader An HandlerInterface instance
     *
     * @return $this
     */
    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[] = $loader;

        return $this;
    }

    /**
     * Loads.
     *
     * @param int $year A year on 4 digits
     *
     * @throws \Exception
     */
    public function import($year)
    {
        $this->em->beginTransaction();

        try {
            $this->load($year);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        $this->em->clear();
    }

    /**
     * Loads data.
     *
     * @param int $year
     */
    private function load($year)
    {
        $season = $this->seasonService->findByYear($year);

        if (!$season) {
            $season = $this->seasonService->create($year);
        }

        foreach ($this->loaders as $loader) {
            /* @var $loader LoaderInterface */
            $loader->load($season);
        }
    }
}
