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
        } catch (\Exception $e) {
            View::share('company_setting', new CompanySetting());
        }
    }
}
