<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Season;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSeasonData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $season1 = new Season(date('Y') - 1);
        $season1->setScoringSystem($this->getReference('scoring-system-foo'));

        $season2 = new Season(date('Y'));
        $season2->setScoringSystem($this->getReference('scoring-system-bar'));

        $this->addReference('season-previous', $season1);
        $this->addReference('season-current', $season2);

        $manager->persist($season1);
        $manager->persist($season2);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Tests\Fixtures\LoadScoringSystemData',
        ];
    }
}
