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
        $constructor1 = new constructor('mercedes');
        $constructor1
            ->setName('Mercedes')
            ->setNationality('DE')
        ;

        $constructor2 = new constructor('ferrari');
        $constructor2
            ->setName('Ferrari')
            ->setNationality('IT')
        ;

        $constructor3 = new constructor('red_bull');
        $constructor3
            ->setName('Red Bull')
            ->setNationality('AT')
        ;

        $constructor4 = new constructor('lotus_f1');
        $constructor4
            ->setName('Lotus F1')
            ->setNationality('GB')
        ;

        $constructor5 = new constructor('mclaren');
        $constructor5
            ->setName('McLaren')
            ->setNationality('GB')
        ;

        $constructor6 = new constructor('williams');
        $constructor6
            ->setName('Williams')
            ->setNationality('GB')
        ;

        $constructor7 = new constructor('toro_rosso');
        $constructor7
            ->setName('Toro Rosso')
            ->setNationality('IT')
        ;

        $constructor8 = new constructor('mclaren');
        $constructor8
            ->setName('McLaren')
            ->setNationality('GB')
        ;

        $constructor9 = new constructor('marussia');
        $constructor9
            ->setName('Marussia')
            ->setNationality('RU')
        ;

        $constructor10 = new constructor('caterham');
        $constructor10
            ->setName('Caterham')
            ->setNationality('MY')
        ;

        $constructor11 = new constructor('caterham');
        $constructor11
            ->setName('Caterham')
            ->setNationality('MY')
        ;

        $constructor12 = new constructor('sauber');
        $constructor12
            ->setName('Sauber')
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
        $this->addReference('constructor-caterham', $constructor11);
        $this->addReference('constructor-sauber', $constructor12);

        $manager->persist($constructor1);
        $manager->persist($constructor2);
        $manager->persist($constructor3);
        $manager->persist($constructor4);
        $manager->persist($constructor8);
        $manager->persist($constructor6);
        $manager->persist($constructor7);
        $manager->persist($constructor9);
        $manager->persist($constructor11);
        $manager->persist($constructor12);

        $manager->flush();
    }
}
