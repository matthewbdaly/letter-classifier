<?php

namespace Matthewbdaly\LetterClassifier\Stages;

use Phpml\Classification\KNearestNeighbors;
use Phpml\ModelManager;

class Train
{
    protected $category;

    protected $classifier;

    protected $manager;

    public function __construct(string $category)
    {
        $this->category = $category;
        $this->manager = new ModelManager;
        if (file_exists('model.txt')) {
            $this->classifier = $this->manager->restoreFromFile('model.txt');
        } else {
            $this->classifier = new KNearestNeighbors;
        }
    }

    public function __invoke(string $text)
    {
        $this->classifier->train([$text], [$this->category]);
        $this->manager->saveToFile($this->classifier, 'model.txt');
    }
}
