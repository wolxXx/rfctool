<?php

declare(strict_types=1);

namespace RfcTool\Entity\Share;

abstract class BaseTable
{
    public const DEFAULT_OPTIONS = [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ];
}