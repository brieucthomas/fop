<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\ConstructorServiceInterface;
use AppBundle\Service\DriverServiceInterface;
use AppBundle\Service\SeasonServiceInterface;
use AppBundle\Service\TeamServiceInterface;
use AppBundle\Utils\Country;
use AppBundle\Utils\Nationality;
use BrieucThomas\ErgastClient\ErgastClientInterface;
use BrieucThomas\ErgastClient\Model as ErgastEntity;

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
     * @var DriverServiceInterface
     */
    protected $driverService;

    /**
     * @var ConstructorServiceInterface
     */
    protected $constructorService;

    /**
     * @var TeamServiceInterface
     */
    protected $teamService;

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

    public function setDriverService(DriverServiceInterface $driverService)
    {
        $this->driverService = $driverService;
    }

    public function setConstructorService(ConstructorServiceInterface $constructorService)
    {
        $this->constructorService = $constructorService;
    }

    public function setTeamService(TeamServiceInterface $teamService)
    {
        $this->teamService = $teamService;
    }

    private function getDriver(ErgastEntity\Driver $ergastDriver)
    {
        $driver = $this->driverService->findBySlug($ergastDriver->getId());

        if (!$driver) {
            $driver = new AppEntity\Driver();
        }

        $driver
            ->setCode($ergastDriver->getCode())
            ->setSlug($ergastDriver->getId())
            ->setNumber($ergastDriver->getNumber())
            ->setFirstName($ergastDriver->getGivenName())
            ->setLastName($ergastDriver->getFamilyName())
            ->setNationality($this->nationality->getCodeByName($ergastDriver->getNationality()))
        ;

        if ($ergastDriver->getBirthDate() instanceof \DateTime) {
            $driver->setBirthDate($ergastDriver->getBirthDate());
        }

        return $driver;
    }

    public function getConstructor(ErgastEntity\Constructor $ergastConstructor)
    {
        $constructor = $this->constructorService->findBySlug($ergastConstructor->getId());

        if (!$constructor) {
            $constructor = new AppEntity\Constructor();
        }

        $constructor
            ->setName($ergastConstructor->getName())
            ->setSlug($ergastConstructor->getId())
            ->setNationality($this->nationality->getCodeByName($ergastConstructor->getNationality()))
        ;

        return $constructor;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTeam(AppEntity\Season $season, ErgastEntity\Constructor $ergastConstructor, ErgastEntity\Driver $ergastDriver)
    {
        $driver = $this->getDriver($ergastDriver);
        $constructor = $this->getConstructor($ergastConstructor);
        $team = $this->teamService->findBySeasonAndDriverAndConstructor($season, $driver, $constructor);

        if (!$team) {
            $team = new AppEntity\Team();
            $team
                ->setSeason($season)
                ->setConstructor($constructor)
                ->setDriver($driver)
            ;
            $this->driverService->save($driver);
            $this->constructorService->save($constructor);
            $this->teamService->save($team);
        }

        return $team;
    }
}
