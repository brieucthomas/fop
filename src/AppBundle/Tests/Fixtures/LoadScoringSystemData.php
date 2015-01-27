<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

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
        $scoringSystem1 = new ScoringSystem('foo');
        $scoringSystem1
            ->setLength(5)
            ->setBonus(1)
        ;

        $scoringSystem2 = new ScoringSystem('bar');
        $scoringSystem2
            ->setLength(4)
            ->setBonus(0)
            ->setIsDefault(true)
        ;

        $manager->persist($scoringSystem1);
        $manager->persist($scoringSystem2);
        $manager->flush();

        $scoringSystem1
            ->addOffset(new ScoringSystemOffset(0, 6))
            ->addOffset(new ScoringSystemOffset(1, 4))
            ->addOffset(new ScoringSystemOffset(2, 2))
        ;

        $scoringSystem2
            ->addOffset(new ScoringSystemOffset(0, 10))
            ->addOffset(new ScoringSystemOffset(1, 8))
            ->addOffset(new ScoringSystemOffset(2, 6))
        ;

        $this->addReference('scoring-system-foo', $scoringSystem1);
        $this->addReference('scoring-system-bar', $scoringSystem2);

        $manager->persist($scoringSystem1);
        $manager->persist($scoringSystem2);
        $manager->flush();
    }
}
