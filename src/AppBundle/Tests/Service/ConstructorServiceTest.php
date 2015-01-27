<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Service;

use AppBundle\Service\ConstructorServiceInterface;
use AppBundle\Tests\WebTestCase;

class ConstructorServiceTest extends WebTestCase
{
    public function testFindConstructorsBySlugs()
    {
        $constructors = $this->getConstructorService()->findBySlugs(['ferrari', 'williams', 'peugeot']);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $constructors);
        $this->assertCount(2, $constructors);
        $this->assertInstanceOf('AppBundle\Entity\Constructor', $constructors->get('ferrari'));
        $this->assertInstanceOf('AppBundle\Entity\Constructor', $constructors->get('williams'));
    }

    /**
     * @return ConstructorServiceInterface
     */
    private function getConstructorService()
    {
        return $this->get('constructor_service');
    }
}
