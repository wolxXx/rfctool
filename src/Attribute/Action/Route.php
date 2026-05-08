<?php

declare(strict_types = 1);

namespace RfcTool\Attribute\Action;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Route
{

    public function __construct(
        public readonly string $path,
        public readonly array  $methods = [\Fig\Http\Message\RequestMethodInterface::METHOD_GET],
        public readonly array  $roles = [\RfcTool\Definition\User\Role::admin],
    ) {}
}
