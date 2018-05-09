<?php

namespace Matthewbdaly\LetterClassifier\Stages;

class GetPolicyNumber
{
    public function __invoke($content)
    {
        $matches = [];
        $policyNumber = '';
        preg_match('/\d{7,9}/', $content, $matches);
        if (count($matches)) {
            $policyNumber = $matches[0];
        }
        return [
            'content' => $content,
            'policy' => $policyNumber
        ];
    }
}
