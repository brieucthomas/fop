<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
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
     * @var RaceServiceInterface
     */
    private $raceService;

    /**
     * Constructor.
     *
     * @param RaceServiceInterface $raceService
     */
    public function __construct(RaceServiceInterface $raceService)
    {
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

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $urlBuilder->findByRound($race->getRound());
            $response = $this->client->execute($urlBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                $standings = clone $race->getDriverStandings();
                foreach ($ergastStanding->getDriverStandings() as $ergastDriverStanding) {
                    /* @var $ergastDriverStanding ErgastEntity\DriverStanding */
                    $driverId = $ergastDriverStanding->getDriver()->getId();
                    $standing = $standings->get($driverId);

                    if (!$standing) {
                        $standing = new AppEntity\DriverStandings();
                        $this->raceService->addDriverStandings($race, $standing);
                    } else {
                        $standings->remove($driverId);
                    }

                    $standing
                        ->setDriver($drivers->get($driverId))
                        ->setPoints($ergastDriverStanding->getPoints())
                        ->setPosition($ergastDriverStanding->getPosition())
                        ->setWins($ergastDriverStanding->getWins())
                    ;
                }

                // clean up remaining entries
                foreach ($standings as $standing) {
                    $this->raceService->removeDriverStandings($race, $standing);
                }

                $this->raceService->persist($race);
            }
        }

        $this->raceService->flush();
    }
}
