<?php

declare(strict_types=1);

namespace RfcTool\Util\View;

class Boolean
{
    public static function get(bool $value): string
    {
        return true === $value ? \RfcTool\Util\DependencyContainer::getInstance()->getTranslator()->yes() : \RfcTool\Util\DependencyContainer::getInstance()->getTranslator()->no();
    }
}
