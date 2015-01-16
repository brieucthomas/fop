<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\FinishingStatusServiceInterface;
use AppBundle\Service\RaceServiceInterface;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Entity\Response;
use BrieucThomas\ErgastClient\Url\Builder\ResultUrlBuilder;

/**
 * The result loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ResultLoader extends AbstractLoader
{
    /**
     * @var RaceServiceInterface
     */
    private $raceService;

    /**
     * @var FinishingStatusServiceInterface
     */
    private $finishingStatusService;

    /**
     * Constructor.
     *
     * @param RaceServiceInterface            $raceService
     * @param FinishingStatusServiceInterface $finishingStatusService
     */
    public function __construct(
        RaceServiceInterface $raceService,
        FinishingStatusServiceInterface $finishingStatusService
    ) {
        $this->raceService = $raceService;
        $this->finishingStatusService = $finishingStatusService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new ResultUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $response = $this->client->execute($urlBuilder->build());
        $finishingStatus = $this->finishingStatusService->findAll();

        foreach ($response->getRaces() as $ergastRace) {
            /* @var $ergastRace ErgastEntity\Race */
            $race = $season->getRaceByRound($ergastRace->getRound());
            $raceResults = clone $race->getResults();
            foreach ($ergastRace->getResults() as $ergastResult) {
                /* @var $ergastResult ErgastEntity\Result */
                $team = $season->getTeamByDriverAndConstructor(
                    $ergastResult->getDriver()->getId(),
                    $ergastResult->getConstructor()->getId()
                );

                $result = $race->getResultByTeamAndPosition($team, $ergastResult->getPosition());

                if (!$result) {
                    $result = new AppEntity\Result();
                    $this->raceService->addResult($race, $result);
                } else {
                    $raceResults->removeElement($result);
                }

                $result
                    ->setPosition($ergastResult->getPosition())
                    ->setTeam($team)
                    ->setGrid($ergastResult->getGrid())
                    ->setFinishingStatus($finishingStatus->get($ergastResult->getStatus()->getName()))
                    ->setLaps($ergastResult->getLaps())
                    ->setPoints($ergastResult->getPoints())
                ;

                if ($ergastResult->getTime()) {
                    $result
                        ->setTime($ergastResult->getTime()->getValue())
                        ->setMilliseconds($ergastResult->getTime()->getMillis())
                    ;
                }

                if ($ergastResult->getFastestLap()) {
                    $result
                        ->setFastestLap($ergastResult->getFastestLap()->getLap())
                        ->setFastestLapRank($ergastResult->getFastestLap()->getRank())
                        ->setFastestLapSpeed($ergastResult->getFastestLap()->getAverageSpeed()->getValue())
                        ->setFastestLapTime($ergastResult->getFastestLap()->getTime())
                    ;
                }
            }

            // clean up remaining results
            foreach ($raceResults as $entry) {
                $this->raceService->removeResult($race, $entry);
            }

            $this->raceService->persist($race);
        }

        $this->raceService->flush();
    }
}
