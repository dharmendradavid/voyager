<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    protected $translatable = ['name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

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

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($category) {
            event(new \TCG\Voyager\Events\NoSqlModelCreated('categories','id', $category->getAttributes()));
        });

        static::updated(function($category) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('categories',$category->id, $category->getAttributes()));
        });

        static::deleted(function($category) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('categories',$category->id));
        });
    }
}
