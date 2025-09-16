<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings data with all views
        View::composer('*', function ($view) {
            $settings = $this->getSettings();
            $view->with('globalSettings', $settings);
        });
    }

    /**
     * Get settings data with caching
     */
    private function getSettings()
    {
        return Cache::remember('site_settings', 3600, function () { // Cache for 1 hour
            $settings = Setting::first();
            
            if (!$settings) {
                // Return default values if no settings exist
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
                    'logo_path' => null
                ];
            }

            return $settings;
        });
    }
}
