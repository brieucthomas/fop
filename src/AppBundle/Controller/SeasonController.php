<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route(name="season_home")
     * @Method({"GET"})
     * @Template(":season:show.html.twig")
     */
    public function showAction(Season $season)
    {
        return [
            'season' => $season
        ];
    }

    /**
     * @Route("/races", name="season_races")
     * @Method({"GET"})
     * @Template(":season:races.html.twig")
     */
    public function racesAction(Season $season)
    {
        return [
            'season' => $season
        ];
    }

    /**
     * @Route("/teams", name="season_teams")
     * @Method({"GET"})
     * @Template(":season:teams.html.twig")
     */
    public function teamsAction(Season $season)
    {
        return [
            'season' => $season
        ];
    }

    /**
     * @Route("/standings", name="season_standings")
     * @Method({"GET"})
     * @Template(":season:standings.html.twig")
     */
    public function standingsAction(Season $season)
    {
        return [
            'season' => $season
        ];
    }
}
