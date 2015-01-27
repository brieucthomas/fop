<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Constructor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The constructor controller.
 *
 * @Route("/constructors")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorController extends Controller
{
    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z0-9\_]+"}, name="constructor")
     * @Method({"GET"})
     * @Template(":constructor:show.html.twig")
     */
    public function showAction(Constructor $constructor)
    {
        return [
            'constructor' => $constructor,
            'wins' => $this->get('result_service')->countWinsByConstructor($constructor->getId()),
            'constructorsChampionships' => $this->get('season_service')->getConstructorsChampionshipsByConstructor($constructor->getId()),
            'driversChampionships' => $this->get('season_service')->getDriversChampionshipsByConstructor($constructor->getId()),
        ];
    }
}
