<?php

declare(strict_types = 1);

namespace RfcTool\Util;

interface Translator
{
    public const string LANGUAGE_DEBUG  = 'xx';
    public const string LANGUAGE_ENGLISH = 'en';
    public const string LANGUAGE_GERMAN  = 'de';



    public function translate($what, ...$args): string;

}
