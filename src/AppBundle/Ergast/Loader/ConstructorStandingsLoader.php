<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\ConstructorStandingsService;
use AppBundle\Service\ConstructorStandingsServiceInterface;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Url\Builder\ConstructorStandingsUrlBuilder;

/**
 * The constructor standings loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsLoader extends AbstractLoader
{
    /**
     * @var ConstructorStandingsServiceInterface
     */
    private $constructorStandingsService;

    /**
     * Constructor.
     *
     * @param ConstructorStandingsServiceInterface $constructorStandingsService
     */
    public function __construct(ConstructorStandingsServiceInterface $constructorStandingsService)
    {
        $this->constructorStandingsService = $constructorStandingsService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new ConstructorStandingsUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $constructors = $season->getConstructors();

        // remove season constructor standings
        $this->constructorStandingsService->removeBySeason($season);

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $urlBuilder->findByRound($race->getRound());
            $response = $this->client->execute($urlBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                foreach ($ergastStanding->getConstructorStandings() as $ergastConstructorStanding) {
                    /* @var $ergastConstructorStanding ErgastEntity\ConstructorStanding */
                    $constructorId = $ergastConstructorStanding->getConstructor()->getId();

                    $standing = new AppEntity\ConstructorStandings();
                    $standing
                        ->setRace($race)
                        ->setConstructor($constructors->get($constructorId))
                        ->setPoints($ergastConstructorStanding->getPoints())
                        ->setPosition($ergastConstructorStanding->getPosition())
                        ->setWins($ergastConstructorStanding->getWins())
                    ;

                    $this->constructorStandingsService->persist($standing);
                }
            }
        }

        $this->constructorStandingsService->flush();
    }
}
