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
use BrieucThomas\ErgastClient\Model as ErgastEntity;
use BrieucThomas\ErgastClient\Request\RequestBuilder;

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
     * Constructor.
     *
     * @param DriverStandingsServiceInterface $driverStandingsService
     */
    public function __construct(DriverStandingsServiceInterface $driverStandingsService)
    {
        $this->driverStandingsService = $driverStandingsService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new RequestBuilder();
        $urlBuilder
            ->findDriverStandings()
            ->bySeason($season->getYear())
        ;
        $drivers = $season->getDrivers();

        // remove season driver standings
        $this->driverStandingsService->removeBySeason($season);

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $urlBuilder->byRound($race->getRound());
            $response = $this->client->execute($urlBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                foreach ($ergastStanding->getDriverStandings() as $ergastDriverStanding) {
                    /* @var $ergastDriverStanding ErgastEntity\DriverStanding */
                    $driverId = $ergastDriverStanding->getDriver()->getId();

                    $driver = $drivers->get($driverId);

                    if (!$driver) {
                        continue 2;
                    }

                    $standing = new AppEntity\DriverStandings();
                    $standing
                        ->setRace($race)
                        ->setDriver($driver)
                        ->setPoints($ergastDriverStanding->getPoints())
                        ->setPosition($ergastDriverStanding->getPosition())
                        ->setWins($ergastDriverStanding->getWins())
                    ;

                    $this->driverStandingsService->save($standing);
                }
            }
        }
    }
}
