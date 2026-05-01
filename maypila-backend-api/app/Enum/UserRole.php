<?php

namespace App\Enum;

enum UserRole : string
{
    case SuperAdmin = 'SuperAdmin';
    case CompanyAdmin = 'CompanyAdmin';
    case QueAdmin = 'QueAdmin';
    case QueEncoder = 'QueEncoder';
}
