<?php

namespace App\Service;

class PhpFunctionsWrapper
{
    public function md5(string $string): string
    {
        return md5($string);
    }

    public function uniqueId(): string
    {
        return uniqid();
    }
}