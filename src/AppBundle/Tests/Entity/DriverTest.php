<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Driver;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    public function testDriver()
    {
        $driver = new Driver('foo');
        $driver
            ->setFirstName('foo')
            ->setLastName('bar')
        ;

        $this->assertSame('foo bar', $driver->getName());
        $this->assertSame('f. bar', $driver->getShortName());
    }
}
