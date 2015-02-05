<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\FinishingPosition;
use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\User;
use AppBundle\Form\PredictionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            'race' => $race,
        ];
    }

    /**
     * @Route("/{season}/{round}/predict/{slug}", name="race_prediction", requirements={"season" = "\d{4}", "round" = "\d+", "slug" = "[a-z_]*"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template(":race:predict.html.twig")
     */
    public function predictAction(Request $request, Race $race, User $user)
    {
        $prediction = $this->get('prediction_repository')->findByRaceAndUser($race, $user);

        if (!$prediction) {
            $prediction = new Prediction($race, $user);
            $limit = $race->getSeason()->getScoringSystem()->getLength();

            for ($position = 1; $position <= $limit; $position++) {
                $prediction->addFinishingPosition(new FinishingPosition($position));
            }
        }

        $this->denyAccessUnlessGranted('edit', $prediction);

        $form = $this->createForm(new PredictionType($race->getSeason()->getYear()), $prediction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('prediction_repository')->save($prediction);

            return $this->redirect(
                $this->generateUrl(
                    'race_prediction',
                    [
                        'season' => $race->getSeason()->getYear(),
                        'round'  => $race->getRound(),
                        'user'   => $user->getSlug(),
                    ]
                )
            );
        }

        return [
            'race' => $race,
            'user' => $user,
            'form' => $form->createView(),
        ];
    }
}
