<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Injects user information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserProcessor
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(array $record)
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return $record;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return $record;
        }

        $record['extra']['user'] = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
        ];

        return $record;
    }
}
