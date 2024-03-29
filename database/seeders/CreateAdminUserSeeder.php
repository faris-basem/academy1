<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::create([
            'name' => 'Faris Basem',
            'email' => 'faris@basem.com',
            'password' => bcrypt('123123')
            ]);
            $role = Role::create(['name' => 'Admin']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
            $user->assignRole([$role->id]);
            
    }
}
