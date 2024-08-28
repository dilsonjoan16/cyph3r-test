<?php
declare (strict_types = 1);

namespace App\Enums;

enum TransactionStatus: int
{
    case PENDING = 1;
    case SUCCESS = 2;
    case FAILED = 3;
}
