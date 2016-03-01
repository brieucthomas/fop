<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Repository\UserRepositoryInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserService implements UserServiceInterface
{
    /**
     * The user repository object.
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepositoryInterface $userRepository The user repository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
