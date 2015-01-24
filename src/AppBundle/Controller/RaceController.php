<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Race;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The race controller.
 *
 * @Route("/races")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceController extends Controller
{
    /**
     * @Route("/{season}/{round}", name="race", requirements={"season" = "\d{4}", "round" = "\d+"})
     * @Method({"GET"})
     * @Template(":race:show.html.twig")
     */
    public function showAction(Race $race)
    {
        return [
            'race' => $race
        ];
    }
}
