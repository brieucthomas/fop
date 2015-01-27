<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Race;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * @Route("/{season}/{round}/predict/{slug}", name="race_prediction", requirements={"season" = "\d{4}", "round" = "\d+", "slug" = "[a-z_]*"})
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     * @Template(":race:predict.html.twig")
     */
    public function predictAction(Race $race, User $user)
    {
        /* @var $loggedUser User */
        $loggedUser = $this->getUser();

        if (!$loggedUser->hasRole('ROLE_ADMIN')) {

            // only admins can edit others predictions
            if ($user != $loggedUser) {
                throw new AccessDeniedException();
            }

            // only admins can edit past predictions
            if ($race->getDate() > new \DateTime()) {
                throw new AccessDeniedException();
            }
        }

        // build a collection of teams
        $teams = $race->getSeason()->getTeams();

        return [
            'race' => $race,
            'user' => $user,
            'teams' => $teams
        ];
    }
}
