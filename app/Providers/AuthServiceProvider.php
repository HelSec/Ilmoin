<?php

namespace App\Providers;

use App\Http\Controllers\Auth\MattermostAuthController;
use App\Users\MattermostSocialiteProvider;
use App\Users\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            if ($user->is_super_admin) {
                return true;
            }
        });

        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'mattermost',
            function ($app) use ($socialite) {
                $config = $app['config']['services.mattermost'];
                return $socialite->buildProvider(MattermostSocialiteProvider::class, $config);
            }
        );
    }
}
