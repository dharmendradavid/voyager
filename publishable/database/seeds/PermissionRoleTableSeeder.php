<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        foreach ($permissions as $permission){
            \TCG\Voyager\Models\PermissionRole::created([
                'role_id' => $role->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
