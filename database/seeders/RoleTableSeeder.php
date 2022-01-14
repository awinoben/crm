<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array('Admin', 'User','Agent');
        foreach ($roles as $role) {
            Role::query()->create([
                'name' => $role
            ]);
        }
    }
}
