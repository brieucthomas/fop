<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Service;

use Tests\WebTestCase;

class CircuitServiceTest extends WebTestCase
{
    public function testFindCircuitsBySlugs()
    {
        $circuits = $this->get('app.service.circuit')->findBySlugs(['monza', 'spa', 'london']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $circuits);
        $this->assertCount(2, $circuits);
        $this->assertInstanceOf('AppBundle\Entity\Circuit', $circuits->get('monza'));
        $this->assertInstanceOf('AppBundle\Entity\Circuit', $circuits->get('spa'));
    }
}
