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
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Url\Builder\ConstructorUrlBuilder;
use BrieucThomas\ErgastClient\Url\Builder\DriverUrlBuilder;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The team loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TeamLoader extends AbstractLoader
{
    /**
     * @var ConstructorServiceInterface
     */
    private $constructorService;

    /**
     * @var DriverServiceInterface
     */
    private $driverService;

    /**
     * Constructor.
     *
     * @param ConstructorServiceInterface $constructorService
     * @param DriverServiceInterface      $driverService
     */
    public function __construct(ConstructorServiceInterface $constructorService, DriverServiceInterface $driverService)
    {
        $this->constructorService = $constructorService;
        $this->driverService = $driverService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        $ergastConstructors = $this->getErgastConstructorsByYear($season->getYear());
        $ergastDrivers = $this->getErgastDriversByYear($season->getYear());

        // load constructors from database
        $constructorIds = $ergastConstructors->map(function (ErgastEntity\Constructor $constructor) {
            return $constructor->getId();
        });
        $constructors = $this->constructorService->findByIds($constructorIds->toArray());

        // load drivers from database
        $driverIds = $ergastDrivers->map(function (ErgastEntity\Driver $driver) {
            return $driver->getId();
        });
        $drivers = $this->driverService->findByIds($driverIds->toArray());

        foreach ($this->getErgastConstructorsByYear($season->getYear()) as $ergastConstructor) {
            /* @var $ergastConstructor ErgastEntity\Constructor */
            $constructor = $constructors->get($ergastConstructor->getId());

            if (!$constructor) {
                $constructor = new AppEntity\Constructor($ergastConstructor->getId());
            }

            $constructor
                ->setName($ergastConstructor->getName())
                ->setNationality($this->nationality->getCodeByName($ergastConstructor->getNationality()))
            ;

            $ergastDrivers = $this->getErgastDriverByYearAndConstructor($season->getYear(), $ergastConstructor);

            foreach ($ergastDrivers as $ergastDriver) {
                /* @var $ergastDriver ErgastEntity\Driver */
                $driver = $drivers->get($ergastDriver->getId());

                if (!$driver) {
                    $driver = new AppEntity\Driver($ergastDriver->getId());
                    $drivers->set($ergastDriver->getId(), $driver);
                }

                $driver
                    ->setCode($ergastDriver->getCode())
                    ->setNumber($ergastDriver->getNumber())
                    ->setFirstName($ergastDriver->getFirstName())
                    ->setLastName($ergastDriver->getLastName())
                    ->setBirthDate($ergastDriver->getBirthDate())
                    ->setNationality($this->nationality->getCodeByName($ergastDriver->getNationality()))
                ;

                $team = $season->getTeamByDriverAndConstructor($driver->getId(), $constructor->getId());

                if (!$team) {
                    $team = new AppEntity\Team($constructor, $driver);
                    $this->seasonService->addTeam($season, $team);
                }
            }
        }

        $this->seasonService->save($season);
    }

    /**
     * Returns the ergast constructors.
     *
     * @param int $year
     *
     * @return ArrayCollection A collection of ergast constructors
     */
    private function getErgastConstructorsByYear($year)
    {
        $urlBuilder = new ConstructorUrlBuilder('f1');
        $urlBuilder->findBySeason($year);
        $response = $this->client->execute($urlBuilder->build());

        return $response->getConstructors();
    }

    /**
     * Returns the ergast drivers.
     *
     * @param int $year
     *
     * @return ArrayCollection A collection of ergast drivers
     */
    private function getErgastDriversByYear($year)
    {
        $urlBuilder = new DriverUrlBuilder('f1');
        $urlBuilder->findBySeason($year);
        $response = $this->client->execute($urlBuilder->build());

        return $response->getDrivers();
    }

    /**
     * Returns the ergast constructors.
     *
     * @param int                      $year
     * @param ErgastEntity\Constructor $constructor
     *
     * @return ArrayCollection A collection of ergast constructors
     */
    private function getErgastDriverByYearAndConstructor($year, ErgastEntity\Constructor $constructor)
    {
        $urlBuilder = new DriverUrlBuilder('f1');
        $urlBuilder
            ->findBySeason($year)
            ->findByConstructor($constructor->getId())
        ;
        $response = $this->client->execute($urlBuilder->build());

        return $response->getDrivers();
    }
}
