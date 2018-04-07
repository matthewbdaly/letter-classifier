#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Matthewbdaly\LetterClassifier\Commands\Processor;
use Matthewbdaly\LetterClassifier\Commands\Trainer;

$application = new Application();
$application->add(new Processor());
$application->add(new Trainer());
$application->run();
