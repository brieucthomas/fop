<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ScoringSystem;
use AppBundle\Entity\ScoringSystemOffset;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadScoringSystemData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $scoringSystem = new ScoringSystem('modern');
        $scoringSystem
            ->setLength(10)
            ->setBonus(15)
            ->setIsDefault(true)
        ;

        $manager->persist($scoringSystem);
        $manager->flush();

        $scoringSystem
            ->addOffset(new ScoringSystemOffset(0, 25))
            ->addOffset(new ScoringSystemOffset(1, 18))
            ->addOffset(new ScoringSystemOffset(2, 15))
            ->addOffset(new ScoringSystemOffset(3, 12))
            ->addOffset(new ScoringSystemOffset(4, 10))
            ->addOffset(new ScoringSystemOffset(5, 8))
            ->addOffset(new ScoringSystemOffset(6, 6))
            ->addOffset(new ScoringSystemOffset(7, 4))
            ->addOffset(new ScoringSystemOffset(8, 2))
            ->addOffset(new ScoringSystemOffset(9, 1))
        ;

        $this->addReference('scoring-system-modern', $scoringSystem);

        $manager->persist($scoringSystem);
        $manager->flush();
    }
}
