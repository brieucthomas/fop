<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security;

use AppBundle\Entity\Prediction;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The prediction voter.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionVoter extends Voter
{
    const SHOW = 'show';
    const EDIT = 'edit';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::SHOW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Prediction) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        /* @var $prediction Prediction */
        $prediction = $subject;

        // administrators can do anythings
        if ($user instanceof UserInterface && $this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        // Finished predictions can be shown be everybody
        if ($attribute === self::SHOW && $prediction->getRace()->isFinished()) {
            return true;
        }

        // Only author can show his prediction
        if ($attribute === self::SHOW && (!$prediction->getRace()->isFinished()) && $user instanceof UserInterface && $prediction->isAuthor($user)) {
            return true;
        }

        // Only author can edit his unfinished prediction
        if ($attribute === self::EDIT && $user instanceof UserInterface && $this->decisionManager->decide($token, ['ROLE_USER']) && $prediction->isAuthor($user) && (!$prediction->getRace()->isFinished())) {
            return true;
        }

        return false;
    }
}
