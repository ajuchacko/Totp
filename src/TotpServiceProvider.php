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
        // $this->loadTranslationsFrom(__DIR__.'/../translations', 'totp');

        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__.'/../config/config.php' => config_path('totp.php'),
        //     ], 'config');


        //     if (! class_exists('CreateTotpTable')) {
        //         $this->publishes([
        //             __DIR__.'/../database/migrations/create_totp_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_totp_table.php'),
        //         ], 'migrations');
        //     }

        //     $this->publishes([
        //         __DIR__.'/../translations' => resource_path('lang/vendor/totp'),
        //     ], 'translations');
        // }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'totp');

        // $this->app->singleton('totp', function ($app) {
        //     $generator = new VoucherGenerator(config('totp.characters'), config('totp.mask'));
        //     $generator->setPrefix(config('totp.prefix'));
        //     $generator->setSuffix(config('totp.suffix'));
        //     $generator->setSeparator(config('totp.separator'));
        //     return new Totp($generator);
        // });
    }
}
