<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';

    protected $fillable = ['table_name', 'column_name', 'foreign_key', 'locale', 'value'];

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($translation) {
            event(new \TCG\Voyager\Events\NoSqlModelCreated('translations','id', $translation->getAttributes()));
        });

        static::updated(function($translation) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('translations',$translation->id, $translation->getAttributes()));
        });

        static::deleted(function($translation) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('translations',$translation->id));
        });
    }
}
