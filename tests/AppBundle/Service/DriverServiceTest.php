<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Service;

use AppBundle\Service\DriverServiceInterface;
use Tests\WebTestCase;

class DriverServiceTest extends WebTestCase
{
    public function testFindDriversBySlugs()
    {
        $drivers = $this->get('app.service.driver')->findBySlugs(['hamilton', 'alonso', 'foo']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $drivers);
        $this->assertCount(2, $drivers);
        $this->assertInstanceOf('AppBundle\Entity\Driver', $drivers->get('hamilton'));
        $this->assertInstanceOf('AppBundle\Entity\Driver', $drivers->get('alonso'));
    }
}
