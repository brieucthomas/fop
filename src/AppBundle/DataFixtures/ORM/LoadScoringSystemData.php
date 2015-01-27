<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ScoringSystem;
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
            ->addOffset(0, 25)
            ->addOffset(1, 18)
            ->addOffset(2, 15)
            ->addOffset(3, 12)
            ->addOffset(4, 10)
            ->addOffset(5, 8)
            ->addOffset(6, 6)
            ->addOffset(7, 4)
            ->addOffset(8, 2)
            ->addOffset(9, 1)
        ;

        $this->addReference('scoring-system-modern', $scoringSystem);

        $manager->persist($scoringSystem);
        $manager->flush();
    }
}
