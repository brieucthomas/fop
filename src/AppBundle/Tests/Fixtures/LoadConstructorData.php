<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Constructor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadConstructorData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $constructor1 = new constructor();
        $constructor1
            ->setName('Mercedes')
            ->setSlug('mercedes')
            ->setNationality('DE')
        ;

        $constructor2 = new constructor();
        $constructor2
            ->setName('Ferrari')
            ->setSlug('ferrari')
            ->setNationality('IT')
        ;

        $constructor3 = new constructor();
        $constructor3
            ->setName('Red Bull')
            ->setSlug('red_bull')
            ->setNationality('AT')
        ;

        $constructor4 = new constructor();
        $constructor4
            ->setName('Lotus F1')
            ->setSlug('lotus_f1')
            ->setNationality('GB')
        ;

        $constructor5 = new constructor();
        $constructor5
            ->setName('McLaren')
            ->setSlug('mclaren')
            ->setNationality('GB')
        ;

        $constructor6 = new constructor();
        $constructor6
            ->setName('Williams')
            ->setSlug('williams')
            ->setNationality('GB')
        ;

        $constructor7 = new constructor();
        $constructor7
            ->setName('Toro Rosso')
            ->setSlug('toro_rosso')
            ->setNationality('IT')
        ;

        $constructor8 = new constructor();
        $constructor8
            ->setName('McLaren')
            ->setSlug('mclaren')
            ->setNationality('GB')
        ;

        $constructor9 = new constructor();
        $constructor9
            ->setName('Marussia')
            ->setSlug('marussia')
            ->setNationality('RU')
        ;

        $constructor10 = new constructor();
        $constructor10
            ->setName('Caterham')
            ->setSlug('caterham')
            ->setNationality('MY')
        ;

        $constructor11 = new constructor();
        $constructor11
            ->setName('Sauber')
            ->setSlug('sauber')
            ->setNationality('CH')
        ;

        $this->addReference('constructor-mercedes', $constructor1);
        $this->addReference('constructor-ferrari', $constructor2);
        $this->addReference('constructor-redbull', $constructor3);
        $this->addReference('constructor-lotusf1', $constructor4);
        $this->addReference('constructor-mclaren', $constructor8);
        $this->addReference('constructor-williams', $constructor6);
        $this->addReference('constructor-tororosso', $constructor7);
        $this->addReference('constructor-marussia', $constructor9);
        $this->addReference('constructor-caterham', $constructor10);
        $this->addReference('constructor-sauber', $constructor11);

        $manager->persist($constructor1);
        $manager->persist($constructor2);
        $manager->persist($constructor3);
        $manager->persist($constructor4);
        $manager->persist($constructor8);
        $manager->persist($constructor6);
        $manager->persist($constructor7);
        $manager->persist($constructor9);
        $manager->persist($constructor10);
        $manager->persist($constructor11);
        $manager->flush();
    }
}
