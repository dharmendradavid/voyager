<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Traits\Translatable;

class PermissionRole extends Model
{
    protected $table = 'permission_role';

    protected $guarded = [];

    /**
     * Booting event handlers thrown by models
     */
    public static function boot()
    {
        parent::boot();

        static::created(function($permissionRole) {

            $permissionRole->table_name = 'table_permission_role';
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $permissionRole->getAttributes()));
        });

        static::updated(function($permissionRole) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_permission_role', $permissionRole->id, $permissionRole->getAttributes()));
        });

        static::deleted(function($permissionRole) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_permission_role', $permissionRole->id));
        });
    }
}
