<?php

namespace Matthewbdaly\LetterClassifier\Stages;

class Train
{
    protected $category;

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function __invoke(string $text)
    {
        eval(\Psy\Sh());
    }
}
