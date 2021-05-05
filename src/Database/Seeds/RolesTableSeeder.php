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
            'guard_name' => 'admin',
            'default' => 0,
            'deletable' => 0
        ]);

        //Needs verification for population permissions, should be diferent
        // DB::table('roles')->insert([
        //     'name' => 'client',
        //     'guard_name' => 'web',
        //     'default' => 1,
        //     'deletable' => 1
        // ]);
    }
}
