<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\NosqlModel;

class Setting extends Model
{
    use NosqlModel;

    protected $table = 'settings';

    protected $guarded = [];
}
