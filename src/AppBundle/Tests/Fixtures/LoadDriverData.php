<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Driver;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDriverData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $driver1 = new Driver('hamilton');
        $driver1
            ->setCode('HAM')
            ->setNumber('44')
            ->setFirstName('Lewis')
            ->setLastName('Hamilton')
            ->setBirthdate(new \DateTime('1985-01-07'))
            ->setNationality('GB')
        ;

        $driver2 = new Driver('rosberg');
        $driver2
            ->setCode('ROS')
            ->setNumber('6')
            ->setFirstName('Nico')
            ->setLastName('Rosberg')
            ->setBirthdate(new \DateTime('1985-06-27'))
            ->setNationality('DE')
        ;

        $driver3 = new Driver('alonso');
        $driver3
            ->setCode('ALO')
            ->setNumber('14')
            ->setFirstName('Fernando')
            ->setLastName('Alonso')
            ->setBirthdate(new \DateTime('1981-07-29'))
            ->setNationality('ES')
        ;

        $driver4 = new Driver('raikkonen');
        $driver4
            ->setCode('RAI')
            ->setNumber('7')
            ->setFirstName('Kimi')
            ->setLastName('Räikkönen')
            ->setBirthdate(new \DateTime('1979-10-17'))
            ->setNationality('FI');

        $driver5 = new Driver('vettel');
        $driver5
            ->setCode('VET')
            ->setNumber('5')
            ->setFirstName('Sebastian')
            ->setLastName('Vettel')
            ->setBirthdate(new \DateTime('1987-07-03'))
            ->setNationality('DE')
        ;

        $driver6 = new Driver('ricciardo');
        $driver6
            ->setCode('RIC')
            ->setNumber('3')
            ->setFirstName('Daniel')
            ->setLastName('Ricciardo')
            ->setBirthdate(new \DateTime('1989-07-01'))
            ->setNationality('AU')
        ;

        $driver7 = new Driver('bottas');
        $driver7
            ->setCode('BOT')
            ->setNumber('77')
            ->setFirstName('Valtteri')
            ->setLastName('Bottas')
            ->setBirthdate(new \DateTime('1989-08-29'))
            ->setNationality('FI')
        ;

        $driver8 = new Driver('massa');
        $driver8
            ->setCode('MAS')
            ->setNumber('19')
            ->setFirstName('Felipe')
            ->setLastName('Massa')
            ->setBirthdate(new \DateTime('1981-04-25'))
            ->setNationality('BR')
        ;

        $driver9 = new Driver('perez');
        $driver9
            ->setCode('PER')
            ->setNumber('11')
            ->setFirstName('Sergio')
            ->setLastName('Pérez')
            ->setBirthdate(new \DateTime('1990-01-26'))
            ->setNationality('MX')
        ;

        $driver10 = new Driver('sutil');
        $driver10
            ->setCode('SUT')
            ->setNumber('99')
            ->setFirstName('Adrian')
            ->setLastName('Sutil')
            ->setBirthdate(new \DateTime('1983-01-11'))
            ->setNationality('DE')
        ;

        $driver11 = new Driver('vergne');
        $driver11
            ->setCode('VER')
            ->setNumber('25')
            ->setFirstName('Jean-Éric')
            ->setLastName('Vergne')
            ->setBirthdate(new \DateTime('1990-04-25'))
            ->setNationality('FR')
        ;

        $driver12 = new Driver('maldonado');
        $driver12
            ->setCode('MAL')
            ->setNumber('13')
            ->setFirstName('Pastor')
            ->setLastName('Maldonado')
            ->setBirthdate(new \DateTime('1985-03-09'))
            ->setNationality('VE')
        ;

        $driver13 = new Driver('kevin_magnussen');
        $driver13
            ->setCode('MAG')
            ->setNumber('20')
            ->setFirstName('Kevin')
            ->setLastName('Magnussen')
            ->setBirthdate(new \DateTime('1992-10-05'))
            ->setNationality('DK')
        ;

        $driver14 = new Driver('lotterer');
        $driver14
            ->setCode('LOT')
            ->setNumber('45')
            ->setFirstName('André')
            ->setLastName('Lotterer')
            ->setBirthdate(new \DateTime('1981-11-19'))
            ->setNationality('DE')
        ;

        $driver15 = new Driver('kvyat');
        $driver15
            ->setCode('KVY')
            ->setNumber('26')
            ->setFirstName('Daniil')
            ->setLastName('Kvyat')
            ->setBirthdate(new \DateTime('1994-04-26'))
            ->setNationality('RU')
        ;

        $driver16 = new Driver('kobayashi');
        $driver16
            ->setCode('KOB')
            ->setNumber('10')
            ->setFirstName('Kamui')
            ->setLastName('Kobayashi')
            ->setBirthdate(new \DateTime('1986-09-13'))
            ->setNationality('JP')
        ;

        $driver17 = new Driver('hulkenberg');
        $driver17
            ->setCode('HUL')
            ->setNumber('27')
            ->setFirstName('Nico')
            ->setLastName('Hülkenberg')
            ->setBirthdate(new \DateTime('1987-08-19'))
            ->setNationality('DE')
        ;

        $driver18 = new Driver('gutierrez');
        $driver18
            ->setCode('GUT')
            ->setNumber('21')
            ->setFirstName('Esteban')
            ->setLastName('Gutiérrez')
            ->setBirthdate(new \DateTime('1991-08-05'))
            ->setNationality('MX')
        ;

        $driver19 = new Driver('grosjean');
        $driver19
            ->setCode('GRO')
            ->setNumber('8')
            ->setFirstName('Romain')
            ->setLastName('Grosjean')
            ->setBirthdate(new \DateTime('1986-04-17'))
            ->setNationality('FR')
        ;

        $driver20 = new Driver('ericsson');
        $driver20
            ->setCode('ERI')
            ->setNumber('9')
            ->setFirstName('Marcus')
            ->setLastName('Ericsson')
            ->setBirthdate(new \DateTime('1990-09-02'))
            ->setNationality('SE')
        ;

        $driver21 = new Driver('chilton');
        $driver21
            ->setCode('CHI')
            ->setNumber('4')
            ->setFirstName('Max')
            ->setLastName('Chilton')
            ->setBirthdate(new \DateTime('1991-04-21'))
            ->setNationality('GB')
        ;

        $driver22 = new Driver('button');
        $driver22
            ->setCode('BUT')
            ->setNumber('22')
            ->setFirstName('Jenson')
            ->setLastName('Button')
            ->setBirthdate(new \DateTime('1980-01-19'))
            ->setNationality('GB')
        ;

        $driver23 = new Driver('jules_bianchi');
        $driver23
            ->setCode('BIA')
            ->setNumber('17')
            ->setFirstName('Jules')
            ->setLastName('Bianchi')
            ->setBirthdate(new \DateTime('1989-08-03'))
            ->setNationality('FR')
        ;

        $this->addReference('driver-hamilton', $driver1);
        $this->addReference('driver-rosberg', $driver2);
        $this->addReference('driver-alonso', $driver3);
        $this->addReference('driver-raikkonen', $driver4);
        $this->addReference('driver-vettel', $driver5);
        $this->addReference('driver-ricciardo', $driver6);
        $this->addReference('driver-bottas', $driver7);
        $this->addReference('driver-massa', $driver8);
        $this->addReference('driver-perez', $driver9);
        $this->addReference('driver-sutil', $driver10);
        $this->addReference('driver-vergne', $driver11);
        $this->addReference('driver-maldonado', $driver12);
        $this->addReference('driver-magnussen', $driver13);
        $this->addReference('driver-lotterer', $driver14);
        $this->addReference('driver-kvyat', $driver15);
        $this->addReference('driver-kobayashi', $driver16);
        $this->addReference('driver-hulkenberg', $driver17);
        $this->addReference('driver-gutierrez', $driver18);
        $this->addReference('driver-grosjean', $driver19);
        $this->addReference('driver-ericsson', $driver20);
        $this->addReference('driver-chilton', $driver21);
        $this->addReference('driver-button', $driver22);
        $this->addReference('driver-bianchi', $driver23);

        $manager->persist($driver1);
        $manager->persist($driver2);
        $manager->persist($driver3);
        $manager->persist($driver4);
        $manager->persist($driver5);
        $manager->persist($driver6);
        $manager->persist($driver7);
        $manager->persist($driver8);
        $manager->persist($driver9);
        $manager->persist($driver10);
        $manager->persist($driver11);
        $manager->persist($driver12);
        $manager->persist($driver13);
        $manager->persist($driver14);
        $manager->persist($driver15);
        $manager->persist($driver16);
        $manager->persist($driver17);
        $manager->persist($driver18);
        $manager->persist($driver19);
        $manager->persist($driver20);
        $manager->persist($driver21);
        $manager->persist($driver22);
        $manager->persist($driver23);
        $manager->flush();
    }
}
