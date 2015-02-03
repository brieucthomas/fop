<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use AppBundle\Entity\ConstructorStandings;
use AppBundle\Entity\DriverStandings;
use AppBundle\Entity\FinishingPosition;
use AppBundle\Entity\FinishingStatus;
use AppBundle\Entity\Prediction;
use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Race;
use AppBundle\Entity\Result;
use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\UserStandings;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Ergast import command.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TestCommand extends ContainerAwareCommand
{
    private $usernames = [
        'brieuc' => 1,
        'michel' => 2,
        'romain' => 3,
        'julie' => 4,
        'mike' => 5,
        'deniel' => 6,
        'arnaud' => 7,
        'djyoda35' => 8,
        'iceman' => 9,
        'ionut' => 10,
    ];

    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $years = [2013, 2014, 2015];

        $em = $this->getContainer()->get('doctrine')->getManager();

        $data = [];

        $users = $em->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user) {
            /* @var $user User */
            $userIndex = 'user_'.$this->usernames[$user->getSlug()];

            $data['AppBundle\Entity\User'][$userIndex] = [
                'username' => $userIndex,
                'password' => $userIndex,
                'enabled' => true,
                'email' => $userIndex.'@fop.com',
                'created' => '2013-06-01',
            ];
        }

        $data['AppBundle\Entity\ScoringSystem']['scoring_system_foo'] = [
            'name' => 'foo',
            'length' => 10,
            'bonus' => 10,
            'offsets' => [25, 18, 15, 12, 10, 8, 6, 4, 2, 1],
        ];

        $statues = $this->getContainer()->get('finishing_status_repository')->findAll();

        foreach ($statues as $status) {
            /* @var $status FinishingStatus */
            $finishingStatusIndex = 'finishing_status_'.$this->slugify($status->getLabel());
            $data['AppBundle\Entity\FinishingStatus'][$finishingStatusIndex] = [
                '__construct' => [$status->getLabel()],
            ];
        }

        foreach ($years as $year) {
            $season = $this->getContainer()->get('season_repository')->findByYear($year);
            $this->generate($season, $data);
        }

        foreach ($data as $key => $values) {
            $parts = explode('\\', $key);
            $part = end($parts);
            file_put_contents(__DIR__.'/../Tests/data/'.strtolower($part).'.yml', Yaml::dump([ $key => $values ], 3));
        }
    }

    private function generate(Season $season, array &$data)
    {
        $seasonIndex = 'season_'.$season->getYear();
        $data['AppBundle\Entity\Season'][$seasonIndex] = [
            '__construct' => [ $season->getYear()],
            'scoringSystem' => '@scoring_system_foo',
        ];

        foreach ($season->getTeams() as $team) {
            /* @var $team Team */
            $driverIndex = 'driver_'.$team->getDriver()->getSlug();
            $constructorIndex = 'constructor_'.$team->getConstructor()->getSlug();
            $teamIndex = 'team_'.$season->getYear().'_'.$team->getConstructor()->getSlug().'_'.$team->getDriver()->getSlug();

            $data['AppBundle\Entity\Driver'][$driverIndex] = [
                'firstName' => $team->getDriver()->getFirstName(),
                'lastName' => $team->getDriver()->getLastName(),
                'slug' => $team->getDriver()->getSlug(),
                'code' => $team->getDriver()->getCode(),
                'number' => $team->getDriver()->getNumber(),
                'nationality' => $team->getDriver()->getNationality(),
                'birthDate' => $team->getDriver()->getBirthDate()->format('Y-m-d'),
            ];

            $data['AppBundle\Entity\Constructor'][$constructorIndex] = [
                'name' => $team->getConstructor()->getName(),
                'nationality' => $team->getConstructor()->getNationality(),
                'slug' => $team->getConstructor()->getSlug(),
            ];

            $data['AppBundle\Entity\Team'][$teamIndex] = [
                '__construct' => ['@'.$constructorIndex, '@'.$driverIndex],
                'season' => '@'.$seasonIndex,
            ];
        }

        foreach ($season->getRaces() as $race) {
            /* @var $race Race */
            $raceIndex = 'race_'.$season->getYear().'_'.$race->getRound();
            $qualifyingIndex = 'qualifying_'.$season->getYear().'_'.$race->getRound();
            $resultIndex = 'result_'.$season->getYear().'_'.$race->getRound();
            $circuitIndex = 'circuit_'.$race->getCircuit()->getSlug();
            $driverStandingsIndex = 'driver_standings_'.$season->getYear().'_'.$race->getRound();
            $constructorStandingsIndex = 'constructor_standings_'.$season->getYear().'_'.$race->getRound();
            $userStandingsIndex = 'user_standings_'.$season->getYear().'_'.$race->getRound();

            $data['AppBundle\Entity\Circuit'][$circuitIndex] = [
                'name' => $race->getCircuit()->getName(),
                'slug' => $race->getCircuit()->getSlug(),
                'location' => $race->getCircuit()->getLocation(),
                'country' => $race->getCircuit()->getCountry(),
            ];

            $data['AppBundle\Entity\Race'][$raceIndex] = [
                'season' => '@'.$seasonIndex,
                'round' => $race->getRound(),
                'name' => $race->getName(),
                'circuit' => '@'.$circuitIndex,
                'date' => $race->getDate()->format('Y-m-d H:i:s'),
            ];

            $i = 1;

            foreach ($race->getQualifying() as $qualifying) {
                /* @var $qualifying Qualifying */
                $teamIndex = 'team_'.$season->getYear().'_'.$qualifying->getTeam()->getConstructor()->getSlug().'_'.$qualifying->getTeam()->getDriver()->getSlug();
                $data['AppBundle\Entity\Qualifying'][$qualifyingIndex.'_'.$i++] = [
                    'race' => '@'.$raceIndex,
                    'position' => $qualifying->getPosition(),
                    'team' => '@'.$teamIndex,
                    'q1' => $qualifying->getQ1(),
                    'q2' => $qualifying->getQ2(),
                    'q3' => $qualifying->getQ3(),
                ];
            }

            $i = 1;

            foreach ($race->getResults() as $result) {
                /* @var $result Result */
                $teamIndex = 'team_'.$season->getYear().'_'.$result->getTeam()->getConstructor()->getSlug().'_'.$result->getTeam()->getDriver()->getSlug();
                $data['AppBundle\Entity\Result'][$resultIndex.'_'.$i++] = [
                    'race' => '@'.$raceIndex,
                    'position' => $result->getPosition(),
                    'team' => '@'.$teamIndex,
                    'grid' => $result->getGrid(),
                    'points' => $result->getPoints(),
                    'laps' => $result->getLaps(),
                    'time' => $result->getTime(),
                    'milliseconds' => $result->getMilliseconds(),
                    'fastestLap' => $result->getFastestLap(),
                    'fastestLapRank' => $result->getFastestLapRank(),
                    'fastestLapTime' => $result->getFastestLapTime(),
                    'fastestLapSpeed' => $result->getFastestLapSpeed(),
                    'finishingStatus' => '@finishing_status_'.$this->slugify($result->getFinishingStatus()->getLabel()),
                ];
            }

            $i = 1;

            foreach ($race->getDriverStandings() as $driverStandings) {
                /* @var $driverStandings DriverStandings */
                $data['AppBundle\Entity\DriverStandings'][$driverStandingsIndex.'_'.$i++] = [
                    'race' => '@'.$raceIndex,
                    'driver' => '@driver_'.$driverStandings->getDriver()->getSlug(),
                    'position' => $driverStandings->getPosition(),
                    'points' => $driverStandings->getPoints(),
                    'wins' => $driverStandings->getWins(),
                ];
            }

            $i = 1;

            foreach ($race->getConstructorStandings() as $constructorStandings) {
                /* @var $constructorStandings ConstructorStandings */
                $data['AppBundle\Entity\ConstructorStandings'][$constructorStandingsIndex.'_'.$i++] = [
                    'race' => '@'.$raceIndex,
                    'constructor' => '@constructor_'.$constructorStandings->getConstructor()->getSlug(),
                    'position' => $constructorStandings->getPosition(),
                    'points' => $constructorStandings->getPoints(),
                    'wins' => $constructorStandings->getWins(),
                ];
            }

            foreach ($race->getUserStandings() as $userStandings) {
                /* @var $userStandings UserStandings */
                $data['AppBundle\Entity\UserStandings'][$userStandingsIndex.'_'.$i++] = [
                    'race' => '@'.$raceIndex,
                    'user' => '@user_'.$this->usernames[$userStandings->getUser()->getSlug()],
                    'position' => $userStandings->getPosition(),
                    'points' => $userStandings->getPoints(),
                    'wins' => $userStandings->getWins(),
                ];
            }

            foreach ($race->getPredictions() as $prediction) {
                /* @var $prediction Prediction */
                $userIndex = $this->usernames[$prediction->getUser()->getSlug()];
                $predictionIndex = 'prediction_'.$season->getYear().'_'.$race->getRound().'_'.$userIndex;
                $data['AppBundle\Entity\Prediction'][$predictionIndex] = [
                    '__construct' => ['@'.$raceIndex, '@user_'.$userIndex],
                    'position' => $prediction->getPosition(),
                    'points' => $prediction->getPoints(),
                ];

                foreach ($prediction->getFinishingPositions() as $finishingPosition) {
                    /* @var $finishingPosition FinishingPosition */
                    $finishingPredictionIndex = 'finishing_position_'.$season->getYear().'_'.$race->getRound().'_'.$userIndex.'_'.$finishingPosition->getPredictedPosition();
                    $teamIndex = 'team_'.$season->getYear().'_'.$finishingPosition->getTeam()->getConstructor()->getSlug().'_'.$finishingPosition->getTeam()->getDriver()->getSlug();
                    $data['AppBundle\Entity\FinishingPosition'][$finishingPredictionIndex] = [
                        '__construct' => [$finishingPosition->getPredictedPosition(), '@'.$teamIndex],
                        'prediction' => '@'.$predictionIndex,
                        'finishingPosition' => $finishingPosition->getFinishingPosition(),
                        'points' => $finishingPosition->getPoints(),
                    ];
                }
            }
        }
    }

    private function slugify($string)
    {
        return trim(str_replace('__', '_', preg_replace(
            '/[^a-z0-9]/', '_', strtolower(trim(strip_tags($string)))
        )), '_');
    }
}
