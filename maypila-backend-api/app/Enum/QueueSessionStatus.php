<?php

namespace App\Enum;

enum QueueSessionStatus: string
{
    case Active = 'Active';
    case InActive = 'InActive';
    case Completed = 'Completed';
}
