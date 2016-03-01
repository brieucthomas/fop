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
            'teams' => $this->get('app.service.team')->findByDriver($driver->getId()),
            'wins' => $this->get('app.service.result')->countWinsByDriver($driver->getId()),
            'podiums' => $this->get('app.service.result')->countPodiumsByDriver($driver->getId()),
            'points' => $this->get('app.service.result')->countPointsByDriver($driver->getId()),
            'races' => $this->get('app.service.result')->countResultsByDriver($driver->getId()),
            'championships' => $this->get('app.service.season')->getChampionshipsByDriver($driver->getId()),
        ];
    }
}
