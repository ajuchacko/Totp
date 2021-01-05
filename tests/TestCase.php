<?php

namespace Ajuchacko\Totp\Tests;


use Ajuchacko\Totp\TotpServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
     public function setUp(): void
    {
        parent::setUp();

        // $this->loadLaravelMigrations(['--database' => 'sqlite']);

        // $this->setUpDatabase();

        // $this->createUser();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TotpServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Totp' => Totp::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    // protected function getEnvironmentSetUp($app)
    // {
    //     $app['config']->set('database.default', 'sqlite');

    //     $app['config']->set('database.connections.sqlite', [
    //         'driver' => 'sqlite',
    //         'database' => ':memory:',
    //         'prefix' => '',
    //     ]);

    //     $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    // }

    // protected function setUpDatabase()
    // {
    //     include_once __DIR__.'/../database/migrations/create_users_table.php.stub';
    //     (new \CreateUsersTable())->up();
    // }

    // protected function createUser()
    // {
    //     User::forceCreate([
    //         'name' => 'User',
    //         'email' => 'user@email.com',
    //         'password' => 'test'
    //     ]);
    // }
}
