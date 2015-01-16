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
use BrieucThomas\ErgastClient\Url\Builder\ConstructorStandingsUrlBuilder;

/**
 * The constructor standings loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandingsLoader extends AbstractLoader
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
        $urlBuilder = new ConstructorStandingsUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $constructors = $season->getConstructors();

        foreach ($season->getRaces() as $race) {
            /* @var $race AppEntity\Race */
            $urlBuilder->findByRound($race->getRound());
            $response = $this->client->execute($urlBuilder->build());
            foreach ($response->getStandings() as $ergastStanding) {
                /* @var $ergastStanding ErgastEntity\Standings */
                $standings = clone $race->getConstructorStandings();
                foreach ($ergastStanding->getConstructorStandings() as $ergastConstructorStanding) {
                    /* @var $ergastConstructorStanding ErgastEntity\ConstructorStanding */
                    $constructorId = $ergastConstructorStanding->getConstructor()->getId();
                    $standing = $standings->get($constructorId);

                    if (!$standing) {
                        $standing = new AppEntity\ConstructorStandings();
                        $this->raceService->addConstructorStandings($race, $standing);
                    } else {
                        $standings->remove($constructorId);
                    }

                    $standing
                        ->setConstructor($constructors->get($constructorId))
                        ->setPoints($ergastConstructorStanding->getPoints())
                        ->setPosition($ergastConstructorStanding->getPosition())
                        ->setWins($ergastConstructorStanding->getWins())
                    ;
                }

                // clean up remaining entries
                foreach ($standings as $standing) {
                    $this->raceService->removeConstructorStandings($race, $standing);
                }

                $this->raceService->persist($race);
            }
        }

        $this->raceService->flush();
    }
}
