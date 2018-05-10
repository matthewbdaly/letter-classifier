<?php

namespace Matthewbdaly\LetterClassifier\Stages;

use Phpml\Dataset\CsvDataset;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Metric\Accuracy;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\ModelManager;

class Classify
{
    protected $classifier;

    protected $vectorizer;

    protected $tfIdfTransformer;

    protected $manager;

    public function __construct()
    {
        $this->manager = new ModelManager;
        $this->dataset = new CsvDataset('data/letters.csv', 1);
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->tfIdfTransformer = new TfIdfTransformer();
        $samples = [];
        foreach ($this->dataset->getSamples() as $sample) {
                $samples[] = $sample[0];
        }
        $this->vectorizer->fit($samples);
        $this->vectorizer->transform($samples);
        $this->tfIdfTransformer->fit($samples);
        $this->tfIdfTransformer->transform($samples);
        $dataset = new ArrayDataset($samples, $this->dataset->getTargets());
        $randomSplit = new StratifiedRandomSplit($dataset, 0.1);
        if (file_exists('model.txt')) {
            $this->classifier = $this->manager->restoreFromFile('model.txt');
        } else {
            $this->classifier = new SVC(Kernel::RBF, 10000);
            $this->classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());
            $predictedLabels = $this->classifier->predict($randomSplit->getTestSamples());
            echo 'Accuracy: '.Accuracy::score($randomSplit->getTestLabels(), $predictedLabels);
        }
    }

    public function __invoke(array $message)
    {
        $newSample = [$message['content']];
        $this->vectorizer->transform($newSample);
        $this->tfIdfTransformer->transform($newSample);
        $message['classification'] = $this->classifier->predict($newSample)[0];
        return $message;
    }
}
