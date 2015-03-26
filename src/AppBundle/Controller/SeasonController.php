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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * The season controller.
 *
 * @Route("/seasons/{year}", requirements={"year" = "\d{4}"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SeasonController extends Controller
{
    /**
     * @Route("/races", name="season_races")
     *
     * @Method({"GET"})
     * @Template(":season:races.html.twig")
     */
    public function racesAction(Season $season)
    {
        return [
            'season' => $season,
        ];
    }

    /**
     * @Route("/teams", name="season_teams")
     *
     * @Method({"GET"})
     * @Template(":season:teams.html.twig")
     */
    public function teamsAction(Season $season)
    {
        return [
            'season' => $season,
        ];
    }

    /**
     * @Route("/standings/user", name="season_user_standings")
     *
     * @Method({"GET"})
     * @Template(":season:user-standings.html.twig")
     */
    public function userStandingsAction(Season $season)
    {
        return [
            'season' => $season,
            'standings' => $this->get('user_standings_service')->findByYear($season->getYear()),
        ];
    }

    /**
     * @Route("/standings/driver", name="season_driver_standings")
     *
     * @Method({"GET"})
     * @Template(":season:driver-standings.html.twig")
     */
    public function driverStandingsAction(Season $season)
    {
        return [
            'season' => $season,
            'standings' => $this->get('driver_standings_service')->findByYear($season->getYear()),
        ];
    }

    /**
     * @Route("/standings/constructor", name="season_constructor_standings")
     *
     * @Method({"GET"})
     * @Template(":season:constructor-standings.html.twig")
     */
    public function constructorStandingsAction(Season $season)
    {
        return [
            'season' => $season,
            'standings' => $this->get('constructor_standings_service')->findByYear($season->getYear()),
        ];
    }

    /**
     * @Route("/graphs", name="season_graphs")
     *
     * @Method({"GET"})
     * @Template(":season:graphs.html.twig")
     */
    public function graphsAction(Season $season)
    {
        return [
            'season' => $season,
        ];
    }

    /**
     * @Route("/graphs/user-standings-data", name="season_graphs_user_standings_data")
     *
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
