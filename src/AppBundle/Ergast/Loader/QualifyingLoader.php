<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use AppBundle\Service\RaceServiceInterface;
use BrieucThomas\ErgastClient\Url\Builder\QualifyingUrlBuilder;

/**
 * Qualifying loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingLoader extends AbstractLoader
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
        $urlBuilder = new QualifyingUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $response = $this->client->execute($urlBuilder->build());

        foreach ($response->getRaces() as $ergastRace) {
            /* @var $ergastRace ErgastEntity\Race */
            $race = $season->getRaceByRound($ergastRace->getRound());
            $raceQualifying = clone $race->getQualifying();
            foreach ($ergastRace->getQualifying() as $ergastQualifying) {
                /* @var $ergastQualifying ErgastEntity\Qualifying */
                $team = $season->getTeamByDriverAndConstructor(
                    $ergastQualifying->getDriver()->getId(),
                    $ergastQualifying->getConstructor()->getId()
                );

                $qualifying = $race->getQualifyingByTeamAndPosition($team, $ergastQualifying->getPosition());

                if (!$qualifying) {
                    $qualifying = new AppEntity\Qualifying();
                    $this->raceService->addQualifying($race, $qualifying);
                } else {
                    $raceQualifying->removeElement($qualifying);
                }

                $qualifying
                    ->setRace($race)
                    ->setPosition($ergastQualifying->getPosition())
                    ->setTeam($team)
                    ->setQ1($ergastQualifying->getQ1())
                    ->setQ2($ergastQualifying->getQ2())
                    ->setQ3($ergastQualifying->getQ3())
                ;

                $this->raceService->persist($race);
            }

            // clean up remaining results
            foreach ($raceQualifying as $entry) {
                $this->raceService->removeQualifying($race, $entry);
            }
        }

        $this->raceService->flush();
    }
}
