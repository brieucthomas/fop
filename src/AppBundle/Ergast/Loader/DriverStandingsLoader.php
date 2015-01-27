<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\DriverStandingsServiceInterface;
use AppBundle\Service\RaceServiceInterface;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Entity\Response;
use BrieucThomas\ErgastClient\Url\Builder\DriverStandingsUrlBuilder;

/**
 * The driver standings loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandingsLoader extends AbstractLoader
{
    /**
     * @var DriverStandingsServiceInterface
     */
    private $driverStandingsService;

    /**
     * @var RaceServiceInterface
     */
    private $raceService;

    /**
     * Constructor.
     *
     * @param RaceServiceInterface            $raceService
     * @param DriverStandingsServiceInterface $driverStandingsService
     */
    public function __construct(DriverStandingsServiceInterface $driverStandingsService, RaceServiceInterface $raceService)
    {
        $this->driverStandingsService = $driverStandingsService;
        $this->raceService = $raceService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new DriverStandingsUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $drivers = $season->getDrivers();

        // remove season driver standings
        $this->driverStandingsService->removeBySeason($season);

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $urlBuilder->findByRound($race->getRound());
            $response = $this->client->execute($urlBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                foreach ($ergastStanding->getDriverStandings() as $ergastDriverStanding) {
                    /* @var $ergastDriverStanding ErgastEntity\DriverStanding */
                    $driverId = $ergastDriverStanding->getDriver()->getId();

                    $standing = new AppEntity\DriverStandings();
                    $standing
                        ->setDriver($drivers->get($driverId))
                        ->setPoints($ergastDriverStanding->getPoints())
                        ->setPosition($ergastDriverStanding->getPosition())
                        ->setWins($ergastDriverStanding->getWins())
                    ;

                    $this->raceService->addDriverStandings($race, $standing);
                }

                $this->raceService->persist($race);
            }
        }

        $this->raceService->flush();
    }
}