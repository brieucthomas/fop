<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase as LiipTest;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class WebTestCase extends LiipTest
{
    /**
     * The last response returned by the application.
     *
     * @var Response
     */
    protected $response;

    /**
     * The Client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * The DomCrawler instance.
     *
     * @var Crawler
     */
    protected $crawler;

    /**
     * The current URL being viewed.
     *
     * @var string
     */
    protected $currentUri;

    protected function setUp()
    {
        parent::setUp();

        $this->loadFixtureFiles([
            __DIR__.'/fixtures/users.yml',
            __DIR__.'/fixtures/scoring_systems.yml',
            __DIR__.'/fixtures/seasons.yml',
            __DIR__.'/fixtures/circuits.yml',
            __DIR__.'/fixtures/races.yml',
            __DIR__.'/fixtures/drivers.yml',
            __DIR__.'/fixtures/constructors.yml',
            __DIR__.'/fixtures/teams.yml',
            __DIR__.'/fixtures/qualifying.yml',
            __DIR__.'/fixtures/finishing_status.yml',
            __DIR__.'/fixtures/results.yml',
            __DIR__.'/fixtures/predictions.yml',
            __DIR__.'/fixtures/finishing_positions.yml',
            __DIR__.'/fixtures/driver_standings.yml',
            __DIR__.'/fixtures/constructor_standings.yml',
            __DIR__.'/fixtures/user_standings.yml',
        ]);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->client = null;
        $this->response = null;
        $this->crawler = null;
        $this->currentUri = null;
    }

    protected function get(string $service)
    {
        return $this->getContainer()->get($service);
    }

    protected function call(string $method, string $uri, array $parameters = [], array $files = [], array $server = [], $content = null, bool $changeHistory = true)
    {
        $this->client = static::createClient();
        $this->client->enableProfiler();

        $this->crawler = $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        $this->response = $this->client->getResponse();
        $this->currentUri = $uri;

        return $this;
    }

    protected function isOk()
    {
        $this->responseStatusIs(200);

        return $this;
    }

    protected function isNotFound()
    {
        $this->responseStatusIs(404);

        return $this;
    }

    protected function responseStatusIs(int $code)
    {
        $actual = $this->response->getStatusCode();

        $this->assertSame($code, $this->response->getStatusCode(), "Expected status code {$code}, got {$actual} (uri: {$this->currentUri}).");

        return $this;
    }

    protected function visit(string $uri)
    {
        return $this->call('GET', $uri);
    }

    protected function seePageIs(string $uri)
    {
        $this->assertSame($uri, $this->currentUri, "Did not land on expected page [{$uri}].\n");

        return $this;
    }

    protected function see(string $text)
    {
        $this->assertGreaterThan(0, $this->crawler->filter('html:contains("'.$text.'")')->count());

        return $this;
    }

    protected function dontSee($text)
    {
        $this->assertSame(0, $this->crawler->filter('html:contains("'.$text.'")')->count());

        return $this;
    }

    public function seeInElement(string $element, string $text)
    {
        $this->assertContains($text, $this->crawler->filter($element)->text());

        return $this;
    }

    protected function seeInDatabase($className, array $criteria)
    {
        /* @var $em EntityManagerInterface */
        $em = $this->get('doctrine')->getEntityManager();
        $data = $em->getRepository($className)->findBy($criteria);

        $this->assertGreaterThan(0, count($data), sprintf(
            'Unable to find row in database table [%s] that matched attributes [%s].', $className, json_encode($data)
        ));

        return $this;
    }

    protected function dontSeeInDatabase($className, array $criteria)
    {
        /* @var $em EntityManagerInterface */
        $em = $this->get('doctrine')->getEntityManager();
        $data = $em->getRepository($className)->findBy($criteria);

        $this->assertEmpty($data, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].', $className, json_encode($data)
        ));

        return $this;
    }

    protected function inMaxQueries(int $number)
    {
        $profile = $this->client->getProfile();
        $queryCount = $profile->getCollector('db')->getQueryCount();

        $this->assertLessThanOrEqual($number, $queryCount, sprintf(
            'Checks that query count is less than %d (token %s)',
            $number,
            $profile->getToken()
        ));
    }
}
