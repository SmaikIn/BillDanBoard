<?php

declare(strict_types=1);

namespace App\Enum;

enum Resource: string
{
    case Company = 'companies';

    case Department = 'departments';
    case Role = 'roles';
    case Profile = 'profiles';

    case User = 'users';
}
