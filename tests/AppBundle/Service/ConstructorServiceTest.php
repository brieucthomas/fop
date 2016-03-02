<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Service;

use Tests\WebTestCase;

class ConstructorServiceTest extends WebTestCase
{
    public function testFindConstructorsBySlugs()
    {
        $constructors = $this->get('app.service.constructor')->findBySlugs(['ferrari', 'williams', 'peugeot']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $constructors);
        $this->assertCount(2, $constructors);
        $this->assertInstanceOf('AppBundle\Entity\Constructor', $constructors->get('ferrari'));
        $this->assertInstanceOf('AppBundle\Entity\Constructor', $constructors->get('williams'));
    }
}
