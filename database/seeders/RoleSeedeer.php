<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        Role::firstOrCreate([
            'name' => Role::ROLE_ADMIN,
        ]);

        // User
        Role::firstOrCreate([
            'name' => Role::ROLE_USER,
        ]);

        // Seller
        Role::firstOrCreate([
            'name' => Role::ROLE_SELLER,
        ]);

        // Tour Manager
        Role::firstOrCreate([
            'name' => Role::ROLE_TOUR_MANAGER,
        ]);
    }
}
