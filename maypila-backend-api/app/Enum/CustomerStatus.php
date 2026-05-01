<?php

namespace App\Enum;

enum CustomerStatus : string
{
    case Pending = 'Pending';
    case InProgress = 'InProgress';
    case Done = 'Done';
}
