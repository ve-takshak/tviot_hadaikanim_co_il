<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'    =>    'admin']);
        Role::create(['name'    =>    'employee']);

        Role::create(['name'    =>  'agent']);
        Role::create(['name'    =>  'assesorial']);
        Role::create(['name'    =>  'client']);
        Role::create(['name'    =>  'lawyer']);
    }
}
