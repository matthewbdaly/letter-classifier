<?php

namespace Matthewbdaly\LetterClassifier\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use League\Pipeline\Pipeline;
use Matthewbdaly\LetterClassifier\Stages\ConvertPdfToPng;
use Matthewbdaly\LetterClassifier\Stages\ReadFile;
use Matthewbdaly\LetterClassifier\Stages\Train;

class Trainer extends Command
{
    protected function configure()
    {
        $this->setName('train')
            ->setDescription('Trains on a file')
            ->setHelp('This command trains on a file')
            ->addArgument('file', InputArgument::REQUIRED, 'File to process')
            ->addArgument('category', InputArgument::REQUIRED, 'Category to apply');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $category = $input->getArgument('category');
        $pipeline = (new Pipeline)
            ->pipe(new ConvertPdfToPng)
            ->pipe(new ReadFile)
            ->pipe(new Train($category));
        $pipeline->process($file);
    }
}

