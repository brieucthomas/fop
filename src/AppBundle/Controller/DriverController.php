<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The driver controller.
 *
 * @Route("/drivers")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverController extends Controller
{
    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z\_]+"}, name="driver")
     *
     * @Method({"GET"})
     * @Template("driver/show.html.twig")
     */
    public function showAction(Driver $driver)
    {
        return [
            'driver' => $driver,
            'teams' => $this->get('team_service')->findByDriver($driver->getId()),
            'wins' => $this->get('result_service')->countWinsByDriver($driver->getId()),
            'podiums' => $this->get('result_service')->countPodiumsByDriver($driver->getId()),
            'points' => $this->get('result_service')->countPointsByDriver($driver->getId()),
            'races' => $this->get('result_service')->countResultsByDriver($driver->getId()),
            'championships' => $this->get('season_service')->getChampionshipsByDriver($driver->getId()),
        ];
    }
}
