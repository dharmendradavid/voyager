<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(Voyager::modelClass('User'), 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Voyager::modelClass('Permission'));
    }

    public static function boot() {

        parent::boot();

        static::created(function($role) {
            event(new \TCG\Voyager\Events\NoSqlModelCreated('roles','id', $role->getAttributes()));
        });

        static::updated(function($role) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('roles',$role->id, $role->getAttributes()));
        });

        static::deleted(function($role) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('roles',$role->id));
        });
    }
}
