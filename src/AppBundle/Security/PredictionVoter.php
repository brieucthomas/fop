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
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }

        if ($attribute === self::SHOW && ($prediction->isAuthor($user) || $prediction->getRace()->isFinished())) {
            return true;
        }

        if ($attribute === self::EDIT && in_array('ROLE_USER', $user->getRoles(), true) && $prediction->isAuthor($user) && !$prediction->getRace()->isFinished()) {
            return true;
        }

        return false;
    }
}
