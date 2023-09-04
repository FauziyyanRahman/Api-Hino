<?php

namespace App\Providers;

use App\Services\Karoseri\IdentityService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use SebastianBergmann\LinesOfCode\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IdentityService::class, function ($app) {
            return new IdentityService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::connection()->getDoctrineConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('msuser_permission', 'string');

        /*
        try {
            DB::connection()->getPDO();
            dump('Database is connected. Database Name is : ' . DB::connection()->getDatabaseName());
         } catch (Exception $e) {
            dump('Database connection failed');
         }*/
    }
}
