<?php

namespace Matthewbdaly\LetterClassifier\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use League\Pipeline\Pipeline;
use Matthewbdaly\LetterClassifier\Stages\ConvertPdfToPng;
use Matthewbdaly\LetterClassifier\Stages\ReadFile;
use Matthewbdaly\LetterClassifier\Stages\Classify;
use Matthewbdaly\LetterClassifier\Stages\StripTabs;
use Matthewbdaly\LetterClassifier\Stages\GetPolicyNumber;

class Processor extends Command
{
    protected function configure()
    {
        $this->setName('process')
            ->setDescription('Processes a file')
            ->setHelp('This command processes a file')
            ->addArgument('file', InputArgument::REQUIRED, 'File to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $pipeline = (new Pipeline)
            ->pipe(new ConvertPdfToPng)
            ->pipe(new ReadFile)
            ->pipe(new StripTabs)
            ->pipe(new GetPolicyNumber)
            ->pipe(new Classify);
        $response = $pipeline->process($file);
        $output->writeln("Classification is ".$response['classification']);
        $output->writeln("Policy number is ".$response['policy']);
    }
}

