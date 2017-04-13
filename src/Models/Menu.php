<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;

/**
 * @todo: Refactor this class by using something like MenuBuilder Helper.
 */
class Menu extends Model
{
    protected $table = 'menus';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Voyager::modelClass('MenuItem'));
    }

    public function parent_items()
    {
        return $this->hasMany(Voyager::modelClass('MenuItem'))
            ->whereNull('parent_id');
    }

    /**
     * Display menu.
     *
     * @param string      $menuName
     * @param string|null $type
     * @param array       $options
     *
     * @return string
     */
    public static function display($menuName, $type = null, array $options = [])
    {
        // GET THE MENU - sort collection in blade
        $menu = static::where('name', '=', $menuName)
            ->with('parent_items.children')
            ->first();

        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        event('voyager.menu.display', $menu);

        // Convert options array into object
        $options = (object) $options;

        // Set static vars values for admin menus
        if (in_array($type, ['admin', 'admin_menu'])) {
            $permissions = Voyager::model('Permission')->all();
            $dataTypes = Voyager::model('DataType')->all();
            $prefix = trim(route('voyager.dashboard', [], false), '/');
            $user_permissions = null;

            if (!Auth::guest()) {
                $user = Voyager::model('User')->find(Auth::id());
                $user_permissions = $user->role->permissions->pluck('key')->toArray();
            }

            $options->user = (object) compact('permissions', 'dataTypes', 'prefix', 'user_permissions');

            // change type to blade template name - TODO funky names, should clean up later
            $type = 'voyager::menu.'.$type;
        } else {
            if (is_null($type)) {
                $type = 'voyager::menu.default';
            } elseif ($type == 'bootstrap' && !view()->exists($type)) {
                $type = 'voyager::menu.bootstrap';
            }
        }

        if (!isset($options->locale)) {
            $options->locale = app()->getLocale();
        }

        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($type, ['items' => $menu->parent_items, 'options' => $options])->render()
        );
    }

    /**
     * Booting event handlers thrown by models
     */
    public static function boot() {

        parent::boot();

        static::created(function($menu) {

            $menu->table_name = 'table_menus';
            event(new \TCG\Voyager\Events\NoSqlModelCreated('ItemsTable', $menu->getAttributes()));
        });

        static::updated(function($menu) {
            event(new \TCG\Voyager\Events\NoSqlModelUpdated('ItemsTable','table_menus', $menu->id, $menu->getAttributes()));
        });

        static::deleted(function($menu) {
            event(new \TCG\Voyager\Events\NoSqlModelDeleted('ItemsTable','table_menus', $menu->id));
        });
    }
}
