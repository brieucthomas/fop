<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Circuit;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCircuitData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $circuit1 = new Circuit('albert_park');
        $circuit1
            ->setName('Albert Park Grand Prix Circuit')
            ->setLocation('Melbourne')
            ->setCountry('AU')
        ;

        $circuit2 = new Circuit('catalunya');
        $circuit2
            ->setName('Circuit de Catalunya')
            ->setLocation('Montmeló')
            ->setCountry('ES')
        ;

        $circuit3 = new Circuit('interlagos');
        $circuit3
            ->setName('Autódromo José Carlos Pace')
            ->setLocation('São Paulo')
            ->setCountry('BR')
        ;

        $circuit4 = new Circuit('monaco');
        $circuit4
            ->setName('Circuit de Monaco')
            ->setLocation('Monte-Carlo')
            ->setCountry('MC')
        ;

        $circuit5 = new Circuit('monza');
        $circuit5
            ->setName('Autodromo Nazionale di Monza')
            ->setLocation('Monza')
            ->setCountry('IT')
        ;

        $circuit6 = new Circuit('suzuka');
        $circuit6
            ->setName('Suzuka Circuit')
            ->setLocation('Suzuka')
            ->setCountry('JP')
        ;

        $circuit7 = new Circuit('spa');
        $circuit7
            ->setName('Circuit de Spa-Francorchamps')
            ->setLocation('Spa')
            ->setCountry('BE')
        ;

        $circuit8 = new Circuit('yas_marina');
        $circuit8
            ->setName('Yas Marina Circuit')
            ->setLocation('Abu Dhabi')
            ->setCountry('AE')
        ;

        $circuit9 = new Circuit('silverstone');
        $circuit9
            ->setName('Silverstone Circuit')
            ->setLocation('Silverstone')
            ->setCountry('GB')
        ;

        $this->addReference('circuit-albert-park', $circuit1);
        $this->addReference('circuit-catalunya', $circuit2);
        $this->addReference('circuit-interlagos', $circuit3);
        $this->addReference('circuit-monaco', $circuit4);
        $this->addReference('circuit-monza', $circuit5);
        $this->addReference('circuit-suzuka', $circuit6);
        $this->addReference('circuit-spa', $circuit7);
        $this->addReference('circuit-yas-marina', $circuit8);
        $this->addReference('circuit-silverstone', $circuit9);

        $manager->persist($circuit1);
        $manager->persist($circuit2);
        $manager->persist($circuit3);
        $manager->persist($circuit4);
        $manager->persist($circuit5);
        $manager->persist($circuit6);
        $manager->persist($circuit7);
        $manager->persist($circuit8);
        $manager->persist($circuit9);
        $manager->flush();
    }
}
