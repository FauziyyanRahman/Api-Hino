<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Users;
use App\Providers\UsersServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth; // Add this line

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();

        // Register your custom user provider
        Auth::provider('custom_users', function ($app, array $config) {
            return new UsersServiceProvider($app->make('hash'), Users::class);
        });
    }
}
