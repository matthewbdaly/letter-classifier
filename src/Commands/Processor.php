<?php

namespace Matthewbdaly\LetterClassifier\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Processor extends Command
{
    protected function configure()
    {
        $this->setName('process')
            ->setDescription('Processes a file')
            ->setHelp('This command processes a file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}

