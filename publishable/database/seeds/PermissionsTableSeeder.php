<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_admin',
            'browse_database',
            'browse_media',
            'browse_settings',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::firstOrCreate(['key' => 'browse_menus', 'table_name' => 'menus']);
        Permission::firstOrCreate(['key' => 'read_menus', 'table_name' => 'menus']);
        Permission::firstOrCreate(['key' => 'edit_menus', 'table_name' => 'menus']);
        Permission::firstOrCreate(['key' => 'add_menus', 'table_name' => 'menus']);
        Permission::firstOrCreate(['key' => 'delete_menus', 'table_name' => 'menus']);

        Permission::firstOrCreate(['key' => 'browse_pages', 'table_name' => 'pages']);
        Permission::firstOrCreate(['key' => 'read_pages', 'table_name' => 'pages']);
        Permission::firstOrCreate(['key' => 'edit_pages', 'table_name' => 'pages']);
        Permission::firstOrCreate(['key' => 'add_pages', 'table_name' => 'pages']);
        Permission::firstOrCreate(['key' => 'delete_pages', 'table_name' => 'pages']);

        Permission::firstOrCreate(['key' => 'browse_roles', 'table_name' => 'roles']);
        Permission::firstOrCreate(['key' => 'read_roles', 'table_name' => 'roles']);
        Permission::firstOrCreate(['key' => 'edit_roles', 'table_name' => 'roles']);
        Permission::firstOrCreate(['key' => 'add_roles', 'table_name' => 'roles']);
        Permission::firstOrCreate(['key' => 'delete_roles', 'table_name' => 'roles']);


        Permission::firstOrCreate(['key' => 'browse_users', 'table_name' => 'users']);
        Permission::firstOrCreate(['key' => 'read_users', 'table_name' => 'users']);
        Permission::firstOrCreate(['key' => 'edit_users', 'table_name' => 'users']);
        Permission::firstOrCreate(['key' => 'add_users', 'table_name' => 'users']);
        Permission::firstOrCreate(['key' => 'delete_users', 'table_name' => 'users']);

        Permission::firstOrCreate(['key' => 'browse_posts', 'table_name' => 'posts']);
        Permission::firstOrCreate(['key' => 'read_posts', 'table_name' => 'posts']);
        Permission::firstOrCreate(['key' => 'edit_posts', 'table_name' => 'posts']);
        Permission::firstOrCreate(['key' => 'add_posts', 'table_name' => 'posts']);
        Permission::firstOrCreate(['key' => 'delete_posts', 'table_name' => 'posts']);

        Permission::firstOrCreate(['key' => 'browse_categories', 'table_name' => 'categories']);
        Permission::firstOrCreate(['key' => 'read_categories', 'table_name' => 'categories']);
        Permission::firstOrCreate(['key' => 'edit_categories', 'table_name' => 'categories']);
        Permission::firstOrCreate(['key' => 'add_categories', 'table_name' => 'categories']);
        Permission::firstOrCreate(['key' => 'delete_categories', 'table_name' => 'categories']);

    }
}
