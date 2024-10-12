<?php

namespace App\Enums;

enum RolesEnum : string
{
    case MANAGER = 'Manager';
    case STAFF = 'Staff';
    case ADMIN = 'Guest';
}

