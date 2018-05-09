<?php

namespace Matthewbdaly\LetterClassifier\Stages;

class StripTabs
{
    public function __invoke($content)
    {
        return trim(preg_replace('/\s+/', ' ', $content));
    }
}
