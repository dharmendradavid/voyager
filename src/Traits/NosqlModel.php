<?php
/**
 * Created by PhpStorm.
 * User: daviddharmendra
 * Date: 4/14/17
 * Time: 10:10 AM
 */

namespace TCG\Voyager\Traits;


trait NosqlModel
{
    public $getImageUrl = null;
    public $getSummary = null;
    public $getTitle = null;


    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($content) {

            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $content->getNoSqlAttributes($tablename, $content)));
        });

        static::updated(function($content) {
            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable', $tablename, $content->{config('voyager.real_time_co.secondary_key_mysql')}, $content->getNoSqlAttributes($tablename, $content)));
        });

        static::deleted(function($content) {
            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable', $tablename, $content->{config('voyager.real_time_co.secondary_key_mysql')}));
        });
    }

    /**
     * Function creates the Items table content for NoSql database
     *
     * @param $tablename
     * @param $content
     * @return array
     */
    public function getNosqlAttributes($tablename, $content)
    {
        $data = [
            'Section' => $tablename,
            'createdTimeStamp' => config('voyager.real_time_co')['secondary_key_function']($content->{config('voyager.real_time_co.secondary_key_mysql')}),
            'imageURL' => $content->{$content->getImageURL},
            'metaData' => $content->getAttributes(),
            'Summary' => $content->{$content->getSummary},
            'Title' => $content->{$content->getTitle}
        ];

        return $data;
    }
}