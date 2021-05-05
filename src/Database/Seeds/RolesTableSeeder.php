<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
            'default' => 0,
            'deletable' => 0
        ]);

        DB::table('roles')->insert([
            'name' => 'client',
            'guard_name' => 'web',
            'default' => 1,
            'deletable' => 1
        ]);
    }
}
