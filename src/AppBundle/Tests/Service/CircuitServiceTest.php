<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Service;

use AppBundle\Service\CircuitServiceInterface;
use AppBundle\Tests\WebTestCase;

class CircuitServiceTest extends WebTestCase
{
    public function testFindCircuitsByIds()
    {
        $circuits = $this->getCircuitService()->findByIds(['monza', 'spa', 'london']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $circuits);
        $this->assertCount(2, $circuits);
        $this->assertInstanceOf('AppBundle\Entity\Circuit', $circuits->get('monza'));
        $this->assertInstanceOf('AppBundle\Entity\Circuit', $circuits->get('spa'));
    }

    /**
     * @return CircuitServiceInterface
     */
    private function getCircuitService()
    {
        return $this->get('circuit_service');
    }
}
