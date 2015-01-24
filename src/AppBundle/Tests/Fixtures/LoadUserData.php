<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1
            ->setUsername('foo')
            ->setPassword('foo')
            ->setEnabled(true)
            ->setEmail('foo@test.com')
            ->setCreated(new \DateTime('2013-06-01'))
        ;

        $user2 = new User();
        $user2
            ->setUsername('bar')
            ->setPassword('bar')
            ->setEnabled(true)
            ->setEmail('bar@test.com')
        ;

        $user3 = new User();
        $user3
            ->setUsername('baz')
            ->setPassword('baz')
            ->setEnabled(true)
            ->setEmail('baz@test.com')
        ;

        $this->addReference('user-foo', $user1);
        $this->addReference('user-bar', $user2);
        $this->addReference('user-baz', $user3);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();
    }
}
