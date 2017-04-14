<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Traits\NosqlModel;
use TCG\Voyager\Traits\Translatable;

class PermissionRole extends Model
{
    use NosqlModel;

    protected $table = 'permission_role';

    protected $guarded = [];


}
