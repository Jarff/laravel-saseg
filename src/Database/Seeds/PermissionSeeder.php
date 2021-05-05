<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Providers\PermissionKey;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clear cache
        // php artisan cache:forget spatie.permission.cache
        // php artisan db:seed --class=PermissionSeeder
        foreach (PermissionKey::getConstants() as $key => $modulo) {
            foreach($modulo['permissions'] as $permiso){
                if(!DB::table('permissions')->where('name', $permiso['name'])->first()){
                    DB::table('permissions')->insert([
                            'name' => $permiso['name'],
                            'guard_name' => 'admin',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }
}