<?php

declare(strict_types = 1);

namespace RfcTool\Definition\Proposal;

enum CalculationBase: string
{
    case TWO_THIRDS      = 'two-thirds';

    case THREE_QUARTERS  = 'three-quarters';

    case SIMPLE_MAJORITY = 'simple-majority';

    case ALL             = 'all';

}