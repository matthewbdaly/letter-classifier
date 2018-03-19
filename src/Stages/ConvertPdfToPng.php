<?php

namespace Matthewbdaly\LetterClassifier\Stages;

use Imagick;

class ConvertPdfToPng
{
    public function __invoke($file)
    {
        $tmp = tmpfile();
        $img = new Imagick($file);
        $img->setFormat('png');
        $img->writeImage($tmp);
        return $tmp;
    }
}
