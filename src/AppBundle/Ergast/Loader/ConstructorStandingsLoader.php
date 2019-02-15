<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\ConstructorStandingsServiceInterface;
use BrieucThomas\ErgastClient\Model as ErgastEntity;
use BrieucThomas\ErgastClient\Request\RequestBuilder;

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
        $requestBuilder = new RequestBuilder();
        $requestBuilder
            ->findConstructorStandings()
            ->bySeason($season->getYear())
        ;
        $constructors = $season->getConstructors();

        // remove season constructor standings
        $this->constructorStandingsService->removeBySeason($season);

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $requestBuilder->byRound($race->getRound());
            $response = $this->client->execute($requestBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                foreach ($ergastStanding->getConstructorStandings() as $ergastConstructorStanding) {
                    /* @var $ergastConstructorStanding ErgastEntity\ConstructorStanding */
                    $constructorId = $ergastConstructorStanding->getConstructor()->getId();

                    $constructor = $constructors->get($constructorId);

                    if (!$constructor) {
                        continue 2;
                    }
                    
                    $standing = new AppEntity\ConstructorStandings();
                    $standing
                        ->setRace($race)
                        ->setConstructor($constructor)
                        ->setPoints($ergastConstructorStanding->getPoints())
                        ->setPosition($ergastConstructorStanding->getPosition())
                        ->setWins($ergastConstructorStanding->getWins())
                    ;

                    $this->constructorStandingsService->save($standing);
                }
            }
        }
    }
}
