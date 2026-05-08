<?php

declare(strict_types=1);

namespace RfcTool\Action\Share;

trait SimpleRoute
{
    public static function getRoute(): string
    {
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \RfcTool\Attribute\Action\Route::class) as $attribute) {
            return $attribute->getArguments()['path'];
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }
}
