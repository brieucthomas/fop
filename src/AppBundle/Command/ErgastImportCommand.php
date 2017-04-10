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
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $io = new SymfonyStyle($input, $output);
        $year = $input->getArgument('year');

        if ('current' === $year) {
            $years = [date('Y')];
        } elseif ('all' === $year) {
            $years = range(1950, date('Y'));
        } else {
            $years = [(int) $year];
        }

        $importer = $this->getContainer()->get('app.ergast.importer');

        foreach ($years as $year) {
            $io->title(sprintf('%d Formula One season', $year));
            $s = microtime(true);
            $importer->import($year);
            $e = microtime(true);
            $io->comment('Memory usage after: '.(memory_get_usage() / 1024).' KB');
            $io->comment('in '.(int) ($e - $s).' secondes');
        }
    }
}
