<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/users")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z0-9\-]+"}, name="user")
     * @Method({"GET"})
     */
    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
