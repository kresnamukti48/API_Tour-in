<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;

    public const ROLE_ADMIN = 'Administrator';
    public const ROLE_USER = 'User';
    public const ROLE_SELLER = 'Seller';
    public const ROLE_TOUR_MANAGER = 'Tour Manager';
}
