<?php

namespace Matthewbdaly\LetterClassifier\Stages;

use thiagoalessio\TesseractOCR\TesseractOCR;

class ReadFile
{

    public function __invoke($file)
    {
        $uri = stream_get_meta_data($file)['uri'];
        $ocr = new TesseractOCR($uri);
        return $ocr->lang('eng')->run();
    }
}
