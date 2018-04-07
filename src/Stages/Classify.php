<?php

namespace Matthewbdaly\LetterClassifier\Stages;

use Phpml\Classification\NaiveBayes;
use Phpml\ModelManager;

class Classify
{
    protected $classifier;

    protected $manager;

    public function __construct()
    {
        $this->manager = new ModelManager;
        if (file_exists('model.txt')) {
            $this->classifier = $this->manager->restoreFromFile('model.txt');
        } else {
            $this->classifier = new NaiveBayes;
        }
    }

    public function __invoke(string $text)
    {
        return $this->classifier->predict([$text]);
    }
}
