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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The user controller.
 *
 * @Route("/users")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @Route("/{slug}", requirements={"slug" = "[a-z\-]+"}, name="user_show")
     * @Method({"GET"})
     * @Template("user/show.html.twig")
     */
    public function showAction(User $user)
    {
        return ['user' => $user];
    }
}
