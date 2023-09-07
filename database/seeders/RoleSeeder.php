<?php

namespace Database\Seeders;

use App\Http\Constants\ERoleConstants;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['role'=>ERoleConstants::ROLE_ADMIN],
            ['role'=>ERoleConstants::ROLE_TEACHER],
            ['role'=>ERoleConstants::ROLE_STUDENT],
        ]);
    }
}
