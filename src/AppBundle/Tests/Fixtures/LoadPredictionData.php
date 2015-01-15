<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\FinishingPosition;
use AppBundle\Entity\Race;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPredictionData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this
            ->loadPreviousSeasonPredictions()
            ->loadCurrentSeasonPredictions()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Tests\Fixtures\LoadUserData',
            'AppBundle\Tests\Fixtures\LoadRaceData',
        ];
    }

    private function loadPreviousSeasonPredictions()
    {
        $prediction1 = new Prediction($this->getReference('race-previous-1'), $this->getReference('user-foo'));
        $prediction1
            ->addFinishingPosition(new FinishingPosition(1, $this->getReference('team-previous-mercedes-hamilton')))
            ->addFinishingPosition(new FinishingPosition(2, $this->getReference('team-previous-mercedes-rosberg')))
            ->addFinishingPosition(new FinishingPosition(3, $this->getReference('team-previous-ferrari-alonso')))
            ->addFinishingPosition(new FinishingPosition(4, $this->getReference('team-previous-redbull-vettel')))
            ->addFinishingPosition(new FinishingPosition(5, $this->getReference('team-previous-mclaren-button')))
        ;

        $this->manager->persist($prediction1);
        $this->manager->flush();

        return $this;
    }

    private function loadCurrentSeasonPredictions()
    {
        return $this;
    }
}
