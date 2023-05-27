<?php

namespace App\Enums;

enum RepetetionTypeEnum: int
{
    case daily = 1;
    case weekly = 2;
    case monthly = 3;
    case yearly = 4;
}