<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCountryCodeByItsName()
    {
        $country = new Country();
        $country
            ->set('Saint Pierre and Miquelon', 'PM')
            ->set('Greenland', 'GL')
            ->set('Hong Kong', 'HK')
        ;

        $this->assertTrue($country->has('Saint Pierre and Miquelon'));
        $this->assertTrue($country->has('Hong Kong'));
        $this->assertTrue($country->has('Greenland'));
        $this->assertFalse($country->has('Foo Bar'));
        $this->assertSame('PM', $country->getCodeByName('Saint Pierre and Miquelon'));
        $this->assertSame('HK', $country->getCodeByName('Hong Kong'));
        $this->assertSame('GL', $country->getCodeByName('Greenland'));
    }

    public function testLoadCountriesFromYamlConfiguration()
    {
        $country = Country::loadFromYaml(__DIR__.'/../data/countries.yml');

        $this->assertSame('AE', $country->getCodeByName('United Arab Emirates'));
        $this->assertSame('CO', $country->getCodeByName('Colombia'));
        $this->assertSame('VA', $country->getCodeByName('Holy See (Vatican City)'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Could not find the country "foo"
     */
    public function testCountryHelperThrowsExceptionOnCountryNotFound()
    {
        $country = new Country();
        $country->getCodeByName('foo');
    }
}
