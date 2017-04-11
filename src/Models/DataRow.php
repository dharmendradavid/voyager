<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class DataRow extends Model
{
    protected $table = 'data_rows';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($datarow) {
            event(new \TCG\Voyager\Events\NoSqlModelCreated('data_rows','id', $datarow->getAttributes()));
        });

        static::updated(function($datarow) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('data_rows',$datarow->id, $datarow->getAttributes()));
        });

        static::deleted(function($datarow) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('data_rows',$datarow->id));
        });
    }
}
