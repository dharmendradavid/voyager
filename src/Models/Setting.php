<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($setting) {
            event(new \TCG\Voyager\Events\NoSqlModelCreated('settings','id', $setting->getAttributes()));
        });

        static::updated(function($setting) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('settings',$setting->id, $setting->getAttributes()));
        });

        static::deleted(function($setting) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('settings',$setting->id));
        });
    }
}
