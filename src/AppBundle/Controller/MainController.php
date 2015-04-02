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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The main controller.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @Method({"GET"})
     * @Template("main/homepage.html.twig")
     */
    public function homepageAction()
    {
        return [
            'nextRace' => $this->get('race_service')->findNextRace(),
            'lastRace' => $this->get('race_service')->findLastRace(),
        ];
    }
}
