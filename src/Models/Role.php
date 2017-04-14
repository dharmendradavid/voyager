<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\NosqlModel;

class Role extends Model
{

    use NosqlModel;

    protected $table = 'roles';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(Voyager::modelClass('User'), 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Voyager::modelClass('Permission'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(PermissionRole::class);
    }
}
