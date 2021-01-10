<?php

namespace Ajuchacko\Totp;

use Illuminate\Support\ServiceProvider;

class TotpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('totp.php'),
            ], 'config');


            if (! class_exists('AddUriToUsersTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/add_uri_to_users_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_add_uri_to_users_table.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        # code...
    }
}
