<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\NosqlModel;

class Translation extends Model
{

    use NosqlModel;

    protected $table = 'translations';

    protected $fillable = ['table_name', 'column_name', 'foreign_key', 'locale', 'value'];
}
