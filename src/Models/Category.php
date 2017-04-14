<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\NosqlModel;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
    use Translatable;
    use NosqlModel;

    protected $translatable = ['name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

    public $getSummary = 'slug';
    public $getTitle = 'name';

    public function posts()
    {
        return $this->hasMany(Voyager::modelClass('Post'))
            ->published()
            ->orderBy('created_at', 'DESC');
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }

//    /**
//     * Booting event handlers thrown by models
//     */
//    public static function boot() {
//
//        parent::boot();
//
//        static::created(function($category) {
//
//            $category->table_name = 'table_categories';
//            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $category->getAttributes()));
//        });
//
//        static::updated(function($category) {
//            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_categories', $category->id, $category->getAttributes()));
//        });
//
//        static::deleted(function($category) {
//
//            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_categories', $category->id));
//        });
//    }
}
