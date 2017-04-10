<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

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
class PredictionComputeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('prediction:compute')
            ->addArgument('year', InputArgument::REQUIRED, 'The season to compute')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $year = ('current' === $input->getArgument('year')) ? date('Y') : $input->getArgument('year');

        $season = $this->getContainer()->get('app.service.season')->findByYear($year);

        if (!$season) {
            throw new \Exception('Season not found');
        }

        $io->title(sprintf('%d Formula One season', $year));
        $io->comment('Computing predictions scores...');

        $this->getContainer()->get('app.service.prediction')->computeBySeason($season);
    }
}
