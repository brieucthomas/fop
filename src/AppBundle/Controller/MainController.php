<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     */
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig', [
            'nextRace' => $this->get('app.service.race')->findNextRace(),
            'lastRace' => $this->get('app.service.race')->findLastRace(),
        ]);
    }
}
