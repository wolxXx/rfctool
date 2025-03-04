<?php

declare(strict_types = 1);

namespace RfcTool\Util\Translator;


class Debug implements
    \RfcTool\Util\Translator
{
    protected function debug(): string
    {
        return new \InvalidArgumentException()->getTrace()[1]['function'] . '()';
    }

    public function translate($what, ...$args): string
    {
        return $this->debug();
    }
}
