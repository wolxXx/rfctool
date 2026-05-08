<?php

declare(strict_types=1);

namespace RfcTool\Definition\Proposal;

enum Result: string
{
    case OPEN     = 'open';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';

    case DRAW     = 'draw';

    case ILLEGAL  = 'illegal';
}