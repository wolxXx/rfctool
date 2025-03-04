<?php

declare(strict_types=1);

namespace RfcTool\Attribute\Action;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Route
{
    public array $methods;

    public function __construct(
        public string $path,
        array         $methods = [\Fig\Http\Message\RequestMethodInterface::METHOD_GET],
        array         $roles = [\RfcTool\Definition\User\Role::admin],
    ) {
        $this->methods = $methods;
    }
}
