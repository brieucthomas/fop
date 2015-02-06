<?php

/*
 * (c) Orange
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Ergast\Loader;

use AppBundle\Entity\Season;
use AppBundle\Ergast\Loader\FinishingStatusLoader;
use AppBundle\Service\FinishingStatusServiceInterface;
use AppBundle\Tests\WebTestCase;
use BrieucThomas\ErgastClient\Entity\FinishingStatus;
use BrieucThomas\ErgastClient\Entity\Response;
use Doctrine\Common\Collections\ArrayCollection;

class FinishingStatusLoaderTest extends WebTestCase
{
    public function testLoader()
    {
        /* @var $service FinishingStatusServiceInterface */
        $service = $this->get('finishing_status_service');

        $this->assertCount(130, $service->findAll());
        $this->assertNotNull($service->findAll()->get('Finished'));
        $this->assertNull($service->findAll()->get('foo'));
        $this->assertNull($service->findAll()->get('bar'));

        $response = new Response();
        $response->setFinishingStatues(new ArrayCollection([
            $this->getErgastFinishingStatus('Finished'),
            $this->getErgastFinishingStatus('foo'),
            $this->getErgastFinishingStatus('bar')
        ]));

        $loader = new FinishingStatusLoader($service);
        $loader->setClient($this->getMockedErgastClient($response));

        $this->assertFalse(\PHPUnit_Framework_Assert::readAttribute($loader, 'loaded'));

        $loader->load(new Season(2010));

        $this->assertTrue(\PHPUnit_Framework_Assert::readAttribute($loader, 'loaded'));
        $this->assertCount(132, $service->findAll());
        $this->assertNotNull($service->findAll()->get('foo'));
        $this->assertNotNull($service->findAll()->get('bar'));

        // another load should do nothing
        $loader->load(new Season(2010));
    }

    private function getMockedErgastClient(Response $response)
    {
        $mock = $this->getMock('BrieucThomas\ErgastClient\ErgastClientInterface');
        $mock
            ->expects($this->once())
            ->method('execute')
            ->willReturn($response)
        ;

        return $mock;
    }

    private function getErgastFinishingStatus($name)
    {
        $status = new FinishingStatus();
        $status->setName($name);

        return $status;
    }
}
