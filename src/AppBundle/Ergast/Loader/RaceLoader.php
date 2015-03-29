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
use AppBundle\Service\CircuitServiceInterface;
use BrieucThomas\ErgastClient\Entity\Response;
use BrieucThomas\ErgastClient\Url\Builder\RaceUrlBuilder;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The race loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceLoader extends AbstractLoader
{
    /**
     * @var CircuitServiceInterface
     */
    private $circuitService;

    /**
     * Constructor.
     *
     * @param CircuitServiceInterface $circuitService
     */
    public function __construct(CircuitServiceInterface $circuitService)
    {
        $this->circuitService = $circuitService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $urlBuilder = new RaceUrlBuilder('f1');
        $urlBuilder->findBySeason($season->getYear());
        $response = $this->client->execute($urlBuilder->build());

        $circuits = $this->loadCircuits($response);
        $races = clone $season->getRaces();

        foreach ($response->getRaces() as $ergastRace) {
            /* @var $ergastRace ErgastEntity\Race */
            $circuit = $circuits->get($ergastRace->getCircuit()->getId());
            $race = $season->getRaceByCircuit($circuit);

            if (!$race) {
                $race = new AppEntity\Race();
            } else {
                $races->remove($ergastRace->getRound());
            }

            $race
                ->setRound($ergastRace->getRound())
                ->setName($ergastRace->getName())
                ->setCircuit($circuit)
                ->setDate($ergastRace->getTime() ? $ergastRace->getTime() : $ergastRace->getDate())
            ;

            $this->seasonService->addRace($season, $race);
        }

        $this->seasonService->save($season);
    }

    /**
     * Loads circuits.
     *
     * @param Response $response The response object
     *
     * @return ArrayCollection A collection of Circuit entities
     */
    private function loadCircuits(Response $response)
    {
        // extract circuit identifiers
        $circuitSlugs = $response->getRaces()->map(function (ErgastEntity\Race $ergastRace) {
            return $ergastRace->getCircuit()->getId();
        });

        // load circuits from database
        $circuits = $this->circuitService->findBySlugs($circuitSlugs->toArray());

        // save new circuits
        foreach ($response->getRaces() as $ergastRace) {
            /* @var $ergastRace ErgastEntity\Race */
            $ergastCircuit = $ergastRace->getCircuit();

            $circuit = $circuits->get($ergastCircuit->getId());

            if (!$circuit) {
                $circuit = new AppEntity\Circuit();
                $circuits->set($ergastCircuit->getId(), $circuit);
            }

            $circuit
                ->setName($ergastCircuit->getName())
                ->setSlug($ergastCircuit->getId())
                ->setLocation($ergastCircuit->getLocation()->getLocality())
                ->setCountry($this->country->getCodeByName($ergastCircuit->getLocation()->getCountry()))
            ;

            $this->circuitService->persist($circuit);
        }

        $this->circuitService->flush();

        return $circuits;
    }
}
