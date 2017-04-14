<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\NosqlModel;

class DataRow extends Model
{

    use NosqlModel;

    protected $table = 'data_rows';

    protected $guarded = [];

    public $timestamps = false;
}
