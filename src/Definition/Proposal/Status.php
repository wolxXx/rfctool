<?php

declare(strict_types = 1);

namespace RfcTool\Definition\Proposal;

enum Status: string
{
    case PREPARE       = 'prepare';

    case READY_TO_VOTE = 'ready-to-vote';

    case VOTING        = 'voting';

    case FINISHED      = 'finished';
}