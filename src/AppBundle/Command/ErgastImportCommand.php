<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use AppBundle\Ergast\Importer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Ergast import command.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ErgastImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ergast:import')
            ->setDescription('Imports season data from Ergast API')
            ->addArgument('year', InputArgument::REQUIRED, 'The season to update')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');

        if ('current' == $year) {
            $years = [date('Y')];
        } elseif ('all' == $year) {
            $years = range(1950, date('Y'));
        } else {
            $years = [(int) $year];
        }

        /* @var $loader Importer */
        $importer = $this->getContainer()->get('ergast_importer');

        foreach ($years as $year) {
            $output->writeln(sprintf('Importing the %d season...', $year));
            $s = microtime(true);
            $importer->import($year);
            $e = microtime(true);
            $output->writeln("Memory usage after: ".(memory_get_usage() / 1024)." KB");
            $output->writeln("in ".($e - $s)." secondes");
        }
    }
}
