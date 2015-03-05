<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The prediction voter.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionVoter extends AbstractVoter
{
    const SHOW = 'show';
    const EDIT = 'edit';

    /**
     * {@inheritdoc}
     */
    protected function getSupportedAttributes()
    {
        return [self::SHOW, self::EDIT];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return ['AppBundle\Entity\Prediction'];
    }

    /**
     * {@inheritdoc}
     */
    protected function isGranted($attribute, $prediction, $user = null)
    {
        $isLogged = ($user instanceof UserInterface);
        $isUser = ($isLogged && in_array('ROLE_USER', $user->getRoles(), true));
        $isAdmin = ($isLogged && in_array('ROLE_ADMIN', $user->getRoles(), true));
        $isFinished = $prediction->getRace()->isFinished();
        $isAuthor = $prediction->isAuthor($user);

        // Administrators can do anythings
        if ($isAdmin) {
            return true;
        }

        // Finished predictions can be shown be everybody
        if ($attribute === self::SHOW && $isFinished) {
            return true;
        }

        // Only author can show his prediction
        if ($attribute === self::SHOW && (!$isFinished) && $isAuthor) {
            return true;
        }

        // Only author can edit his unfinished prediction
        if ($attribute === self::EDIT && $isUser && $isAuthor && (!$isFinished)) {
            return true;
        }

        return false;
    }
}
