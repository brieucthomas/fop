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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/constructors")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorController extends Controller
{
    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z0-9\_]+"}, name="constructor")
     * @Method({"GET"})
     */
    public function showAction(Constructor $constructor)
    {
        return $this->render('constructor/show.html.twig', [
            'constructor' => $constructor,
            'wins' => $this->get('app.service.result')->countWinsByConstructor($constructor->getId()),
            'constructorsChampionships' => $this->get('app.service.season')->getConstructorsChampionshipsByConstructor($constructor->getId()),
            'driversChampionships' => $this->get('app.service.season')->getDriversChampionshipsByConstructor($constructor->getId()),
        ]);
    }
}
