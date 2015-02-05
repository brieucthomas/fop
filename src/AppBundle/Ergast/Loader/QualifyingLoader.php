<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\QualifyingServiceInterface;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Url\Builder\QualifyingUrlBuilder;

/**
 * Qualifying loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class QualifyingLoader extends AbstractLoader
{
    /**
     * @var QualifyingServiceInterface
     */
    private $qualifyingService;

    /**
     * Constructor.
     *
     * @param QualifyingServiceInterface $qualifyingService
     */
    public function __construct(QualifyingServiceInterface $qualifyingService)
    {
        $this->qualifyingService = $qualifyingService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new QualifyingUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $response = $this->client->execute($urlBuilder->build());

        // remove all season qualifying
        $this->qualifyingService->removeBySeason($season);

        foreach ($response->getRaces() as $ergastRace) {
            /* @var $ergastRace ErgastEntity\Race */
            $race = $season->getRaceByRound($ergastRace->getRound());
            foreach ($ergastRace->getQualifying() as $ergastQualifying) {
                /* @var $ergastQualifying ErgastEntity\Qualifying */
                $team = $season->getTeamByDriverAndConstructor(
                    $ergastQualifying->getDriver()->getId(),
                    $ergastQualifying->getConstructor()->getId()
                );

                $qualifying = new AppEntity\Qualifying();

                $qualifying
                    ->setRace($race)
                    ->setPosition($ergastQualifying->getPosition())
                    ->setTeam($team)
                    ->setQ1($ergastQualifying->getQ1())
                    ->setQ2($ergastQualifying->getQ2())
                    ->setQ3($ergastQualifying->getQ3())
                ;

                $this->qualifyingService->persist($qualifying);
            }
        }

        $this->qualifyingService->flush();
    }
}
