#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Matthewbdaly\LetterClassifier\Commands\Processor;

$application = new Application();
$application->add(new Processor());
$application->run();
