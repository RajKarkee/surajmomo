<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getSetting')) {
    /**
     * Get a specific setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSetting($key, $default = null)
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return Setting::first();
        });

        if (!$settings) {
            return $default;
        }

        return $settings->{$key} ?? $default;
    }
}

if (!function_exists('getAllSettings')) {
    /**
     * Get all settings as an object
     *
     * @return object
     */
    function getAllSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
            $settings = Setting::first();
            
            if (!$settings) {
                return (object) [
                    'site_name' => 'Momo Restaurant',
                    'contact_email' => '',
                    'contact_phone' => '',
                    'facebook_link' => '',
                    'twitter_link' => '',
                    'instagram_link' => '',
                    'time' => '',
                    'address' => '',
                    'map_link' => '',
                    'primary_color' => '#e74c3c',
                    'secondary_color' => '#27ae60',
                    'accent_color' => '#f39c12',
                    'dark_color' => '#2c3e50',
                    'light_color' => '#ecf0f1',
                    'white_color' => '#ffffff',
                    
                    'logo_path' => null
                ];
            }

            return $settings;
        });
    }
}

if (!function_exists('clearSettingsCache')) {
    /**
     * Clear the settings cache
     *
     * @return void
     */
    function clearSettingsCache()
    {
        Cache::forget('site_settings');
    }
}
