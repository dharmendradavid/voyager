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

        static::created(function($dataRow) {

            $dataRow->table_name = 'table_data_rows';
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $dataRow->getAttributes()));
        });

        static::updated(function($dataRow) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_data_rows', $dataRow->id, $dataRow->getAttributes()));
        });

        static::deleted(function($dataRow) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_data_rows', $dataRow->id));
        });
    }
}
