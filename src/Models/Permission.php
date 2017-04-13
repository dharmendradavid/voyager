<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public static function generateFor($table_name)
    {
        self::firstOrCreate(['key' => 'browse_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'read_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'edit_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'add_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'delete_'.$table_name, 'table_name' => $table_name]);
    }

    public static function removeFrom($table_name)
    {
        self::where(['table_name' => $table_name])->delete();
    }

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($permission) {

            $permission->table_name = 'table_permissions';
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $permission->getAttributes()));
        });

        static::updated(function($permission) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_permissions', $permission->id, $permission->getAttributes()));
        });

        static::deleted(function($permission) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_permissions', $permission->id));
        });
    }
}
