<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\FinishingStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFinishingStatusData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $status1 = new FinishingStatus('Finished');
        $status2 = new FinishingStatus('Accident');
        $status3 = new FinishingStatus('Engine');
        $status4 = new FinishingStatus('+1 Lap');

        $this->addReference('finishing-status-finished', $status1);
        $this->addReference('finishing-status-accident', $status2);
        $this->addReference('finishing-status-engine', $status3);
        $this->addReference('finishing-status-one-lap', $status4);

        $manager->persist($status1);
        $manager->persist($status2);
        $manager->persist($status3);
        $manager->persist($status4);
        $manager->flush();
    }
}
