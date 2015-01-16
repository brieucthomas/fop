<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Service\SeasonServiceInterface;
use AppBundle\Utils\Country;
use AppBundle\Utils\Nationality;
use BrieucThomas\ErgastClient\ErgastClientInterface;

/**
 * Base class for laoders.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var ErgastClientInterface
     */
    protected $client;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Nationality
     */
    protected $nationality;

    /**
     * @var SeasonServiceInterface
     */
    protected $seasonService;

    /**
     * Sets the ergast client.
     *
     * @param ErgastClientInterface $client
     *
     * @return $this
     */
    public function setClient(ErgastClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Sets the country helper.
     *
     * @param Country $country
     *
     * @return $this
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Sets the nationality helper.
     *
     * @param Nationality $nationality
     *
     * @return $this
     */
    public function setNationality(Nationality $nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Sets the season service.
     *
     * @param SeasonServiceInterface $service
     *
     * @return $this
     */
    public function setSeasonService(SeasonServiceInterface $service)
    {
        $this->seasonService = $service;

        return $this;
    }
}
