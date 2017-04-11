<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Site Title',
                'value'        => 'Site Title',
                'type'         => 'text',
                'order'        => 1,
            ])->save();
        }

        $setting = $this->findSetting('description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Site Description',
                'value'        => 'Site Description',
                'type'         => 'text',
                'order'        => 2,
            ])->save();
        }

        $setting = $this->findSetting('logo');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Site Logo',
                'type'         => 'image',
                'order'        => 3,
            ])->save();
        }

        $setting = $this->findSetting('admin_bg_image');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Admin Background Image',
                'type'         => 'image',
                'order'        => 9,
            ])->save();
        }

        $setting = $this->findSetting('admin_title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Admin Title',
                'value'        => 'Voyager',
                'type'         => 'text',
                'order'        => 4,
            ])->save();
        }

        $setting = $this->findSetting('admin_description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Admin Description',
                'value'        => 'Welcome to Voyager. The Missing Admin for Laravel',
                'type'         => 'text',
                'order'        => 5,
            ])->save();
        }

        $setting = $this->findSetting('admin_loader');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Admin Loader',
                'type'         => 'image',
                'order'        => 6,
            ])->save();
        }

        $setting = $this->findSetting('admin_icon_image');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Admin Icon Image',
                'type'         => 'image',
                'order'        => 7,
            ])->save();
        }

        $setting = $this->findSetting('google_analytics_client_id');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Analytics Client ID',
                'type'         => 'text',
                'order'        => 9,
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
