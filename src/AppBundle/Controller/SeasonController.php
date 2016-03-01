<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Race;
use AppBundle\Entity\Season;
use AppBundle\Entity\UserStandings;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/seasons/{year}", requirements={"year" = "\d{4}"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonController extends Controller
{
    /**
     * @Route("/races", name="season_races")
     * @Method({"GET"})
     */
    public function racesAction(Season $season)
    {
        return $this->render('season/races.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/teams", name="season_teams")
     * @Method({"GET"})
     */
    public function teamsAction(Season $season)
    {
        return $this->render('season/teams.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/standings/user", name="season_user_standings")
     * @Method({"GET"})
     */
    public function userStandingsAction(Season $season)
    {
        return $this->render('season/user-standings.html.twig', [
            'season' => $season,
            'standings' => $this->get('app.service.user_standings')->findByYear($season->getYear()),
        ]);
    }

    /**
     * @Route("/standings/driver", name="season_driver_standings")
     * @Method({"GET"})
     */
    public function driverStandingsAction(Season $season)
    {
        return $this->render('season/driver-standings.html.twig', [
            'season' => $season,
            'standings' => $this->get('app.service.driver_standings')->findByYear($season->getYear()),
        ]);
    }

    /**
     * @Route("/standings/constructor", name="season_constructor_standings")
     * @Method({"GET"})
     */
    public function constructorStandingsAction(Season $season)
    {
        return $this->render('season/constructor-standings.html.twig', [
            'season' => $season,
            'standings' => $this->get('app.service.constructor_standings')->findByYear($season->getYear()),
        ]);
    }

    /**
     * @Route("/graphs", name="season_graphs")
     * @Method({"GET"})
     */
    public function graphsAction(Season $season)
    {
        return $this->render('season/graphs.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/graphs/user-standings-data", name="season_graphs_user_standings_data")
     * @Method({"GET"})
     */
    public function userStandingsGraphAction(Season $season)
    {
        $series = [];

        foreach ($season->getRaces() as $race) {
            /* @var $race Race */
            if ($race->getUserStandings()->isEmpty()) {
                continue; // next race
            }
            $points = $race->getUserStandings()->last()->getPoints();
            foreach ($race->getUserStandings() as $userStandings) {
                /* @var $userStandings UserStandings */
                $index = $userStandings->getUser()->getUsername();
                $series[$index][] = ($userStandings->getPoints() - $points);
            }
        }

        return new JsonResponse($series);
    }
}
