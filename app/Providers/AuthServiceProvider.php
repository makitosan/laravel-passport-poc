<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $options = [
            'prefix' => 'api/v1/oauth',
            'namespace' => '\Laravel\Passport\Http\Controllers',
        ];
        Passport::routes(null, $options);
        Passport::tokensExpireIn(now()->addDays(2));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        //
    }
}
