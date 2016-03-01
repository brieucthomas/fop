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
 * @Route("/races")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceController extends Controller
{
    /**
     * @Route("/{season}/{round}", name="race", requirements={"season" = "\d{4}", "round" = "\d+"})
     * @Method({"GET"})
     */
    public function showAction(Race $race)
    {
        return $this->render('race/show.html.twig', [
            'race' => $race,
        ]);
    }

    /**
     * @Route("/{season}/{round}/predict/{slug}", name="prediction", requirements={"season" = "\d{4}", "round" = "\d+", "slug" = "[a-z0-9_]*"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function predictAction(Request $request, Race $race, User $user)
    {
        $prediction = $this->get('app.service.prediction')->findByRaceAndUser($race, $user);

        if (!$prediction) {
            $prediction = new Prediction($race, $user);
            $limit = $race->getSeason()->getScoringSystem()->getLength();

            for ($position = 1; $position <= $limit; ++$position) {
                $finishingPosition = new FinishingPosition();
                $finishingPosition->setPredictedPosition($position);
                $prediction->addFinishingPosition($finishingPosition);
            }
        }

        $this->denyAccessUnlessGranted('edit', $prediction);

        $form = $this->createForm(new PredictionType($race->getSeason()->getYear()), $prediction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.service.prediction')->save($prediction);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('race.prediction.success'));

            return $this->redirect(
                $this->generateUrl(
                    'prediction',
                    [
                        'season' => $race->getSeason()->getYear(),
                        'round' => $race->getRound(),
                        'slug' => $user->getSlug(),
                    ]
                )
            );
        }

        return $this->render('race/predict.html.twig', [
            'race' => $race,
            'prediction' => $prediction,
            'form' => $form->createView(),
        ]);
    }
}
