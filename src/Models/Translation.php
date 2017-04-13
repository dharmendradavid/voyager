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

            $translation->table_name = 'table_translations';
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $translation->getAttributes()));
        });

        static::updated(function($translation) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_translations', $translation->id, $translation->getAttributes()));
        });

        static::deleted(function($translation) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_translations', $translation->id));
        });
    }
}
