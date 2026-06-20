<?php

namespace App\Providers;

use App\Models\CompanySetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class GlobalVariableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safely check if the schema is available and the table exists
        try {
            if (Schema::hasTable('company_settings')) {
                $company_setting = CompanySetting::first() ?? new CompanySetting();
                View::share('company_setting', $company_setting);
            } else {
                View::share('company_setting', new CompanySetting());
            }

            if (Schema::hasTable('system_modules')) {
                $gtm_head = \App\Models\SystemModule::where('key', 'gtm_head')->first()->value ?? '';
                $gtm_body = \App\Models\SystemModule::where('key', 'gtm_body')->first()->value ?? '';
                View::share('gtm_head', $gtm_head);
                View::share('gtm_body', $gtm_body);
            } else {
                View::share('gtm_head', '');
                View::share('gtm_body', '');
            }
        } catch (\Exception $e) {
            View::share('company_setting', new CompanySetting());
            View::share('gtm_head', '');
            View::share('gtm_body', '');
        }
    }
}
