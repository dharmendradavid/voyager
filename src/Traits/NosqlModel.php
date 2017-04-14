<?php

namespace TCG\Voyager\Traits;

trait NosqlModel
{
    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($content) {

            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelCreated(config('voyager.real_time_co.items_table_name'), $content->getNoSqlAttributes($tablename, $content)));

            if($content->hasMediaItems()) {
                event(new \TCG\Voyager\Events\NoSqlModelCreated(config('voyager.real_time_co.media_items_table_name'), $content->getMediaItemsAttributes($content)));
            }
        });

        static::updated(function($content) {
            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelUpdated(config('voyager.real_time_co.items_table_name'), $tablename, $content->{config('voyager.real_time_co.secondary_key_mysql')}, $content->getNoSqlAttributes($tablename, $content)));

            if($content->hasMediaItems()) {
                $primary = config('voyager.real_time_co')['media_items_primary_key_function']($content->{config('voyager.real_time_co.media_items_primary_key_mysql')});
                $secondary = config('voyager.real_time_co')['media_items_secondary_key_function']($content->{config('voyager.real_time_co.media_items_secondary_key_mysql')});
                event(new \TCG\Voyager\Events\NoSqlModelUpdated(config('voyager.real_time_co.media_items_table_name'), $primary, $secondary, $content->getMediaItemsAttributes($content)));
            }
        });

        static::deleted(function($content) {
            $tablename = config('voyager.real_time_co.table_prefix') .$content->table . config('voyager.real_time_co.table_suffix');
            event(new \TCG\Voyager\Events\NoSqlModelDeleted(config('voyager.real_time_co.items_table_name'), $tablename, $content->{config('voyager.real_time_co.secondary_key_mysql')}));

            if($content->hasMediaItems()) {
                $primary = config('voyager.real_time_co')['media_items_primary_key_function']($content->{config('voyager.real_time_co.media_items_primary_key_mysql')});
                $secondary = config('voyager.real_time_co')['media_items_secondary_key_function']($content->{config('voyager.real_time_co.media_items_secondary_key_mysql')});
                event(new \TCG\Voyager\Events\NoSqlModelDeleted(config('voyager.real_time_co.media_items_table_name'), $primary, $secondary));
            }
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
        $columns = $this->getItemsTableColumns();
        $data = [
            'Section' => $tablename,
            'createdTimeStamp' => config('voyager.real_time_co')['secondary_key_function']($content->{config('voyager.real_time_co.secondary_key_mysql')}),
            'imageURL' => $content->{$columns['imageURL']},
            'metaData' => $content->getAttributes(),
            'Summary' => $content->{$columns['Summary']},
            'Title' => $content->{$columns['Title']}
        ];

        return $data;
    }

    /**
     * returns the content to be saved in nosql database
     *
     * @param $content
     * @return array
     */
    public function getMediaItemsAttributes($content)
    {
        $columns = $this->getMediaTableColumns();

        $data = [
            'SeriesName' => config('voyager.real_time_co')['media_items_primary_key_function']($content->{config('voyager.real_time_co.media_items_primary_key_mysql')}),
            'MediaDate' => config('voyager.real_time_co')['media_items_secondary_key_function']($content->{config('voyager.real_time_co.media_items_secondary_key_mysql')}),
            'ItemsTableLink' => config('voyager.real_time_co')['secondary_key_function']($content->{config('voyager.real_time_co.secondary_key_mysql')}),
            'MediaAudioLink' => $content->{$columns['MediaAudioLink']},
            'MediaDescription' => $content->{$columns['MediaDescription']},
            'MediaTitle' => $content->{$columns['MediaTitle']},
            'MediaVideoLink' => $content->{$columns['MediaVideoLink']},
            'SeriesTitle' => $content->{$columns['SeriesTitle']},
            'ShowDates' => $content->{$columns['ShowDates']},
            'ShowSpeaker' => $content->{$columns['ShowSpeaker']},

        ];

        return $data;
    }

    /**
     * Function checks if content is to be saved in MediaItems table
     *
     * @return bool
     */
    public function hasMediaItems()
    {
        return false;
    }

    /**
     * Function returns the column in mysql in terms of nosql
     *
     * @return array
     */
    public function getItemsTableColumns()
    {
        return [
            'imageURL' => null,
            'Summary' => null,
            'Title' => null
        ];
    }

    /**
     * Function returns the column in mysql in terms of nosql
     *
     * @return array
     */
    public function getMediaTableColumns()
    {
        return [
            'MediaAudioLink' => null,
            'MediaDescription' => null,
            'MediaTitle' => null,
            'MediaVideoLink' => null,
            'SeriesTitle' => null,
            'ShowDates' => null,
            'ShowSpeaker' => null,
        ];
    }
}