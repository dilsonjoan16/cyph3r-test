<?php
declare (strict_types = 1);

namespace App\Enums;

enum Role: int
{
    case ADMINISTRATOR = 1;
    case USER = 2;
}
