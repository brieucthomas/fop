<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Service;

use AppBundle\Service\DriverServiceInterface;
use AppBundle\Tests\WebTestCase;

class DriverServiceTest extends WebTestCase
{
    public function testFindDriversBySlugs()
    {
        $drivers = $this->getDriverService()->findBySlugs(['hamilton', 'alonso', 'foo']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $drivers);
        $this->assertCount(2, $drivers);
        $this->assertInstanceOf('AppBundle\Entity\Driver', $drivers->get('hamilton'));
        $this->assertInstanceOf('AppBundle\Entity\Driver', $drivers->get('alonso'));
    }

    /**
     * @return DriverServiceInterface
     */
    private function getDriverService()
    {
        return $this->get('driver_service');
    }
}
