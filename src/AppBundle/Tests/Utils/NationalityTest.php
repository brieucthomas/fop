<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\Nationality;

class NationalityTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNationalityCodeByItsName()
    {
        $nationality = new Nationality();
        $nationality
            ->set('New Zealander', 'NZ')
            ->set('Portuguese', 'PT')
            ->set('South African', 'ZA')
        ;

        $this->assertTrue($nationality->has('New Zealander'));
        $this->assertTrue($nationality->has('Portuguese'));
        $this->assertTrue($nationality->has('South African'));
        $this->assertFalse($nationality->has('Foo Bar'));
        $this->assertSame('NZ', $nationality->getCodeByName('New Zealander'));
        $this->assertSame('PT', $nationality->getCodeByName('Portuguese'));
        $this->assertSame('ZA', $nationality->getCodeByName('South African'));
    }

    public function testLoadCountriesFromYamlConfiguration()
    {
        $nationality = Nationality::loadFromYaml(__DIR__.'/../data/nationalities.yml');

        $this->assertSame('AR', $nationality->getCodeByName('Argentine-Italian'));
        $this->assertSame('LI', $nationality->getCodeByName('Liechtensteiner'));
        $this->assertSame('NZ', $nationality->getCodeByName('New Zealand'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Could not find the nationality "foo"
     */
    public function testNationalityHelperThrowsExceptionOnNationalityNotFound()
    {
        $nationality = new Nationality([]);
        $nationality->getCodeByName('foo');
    }
}
