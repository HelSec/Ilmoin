<?php

namespace App\Providers;

use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
use App\Policies\Organizations\OrganizationGroupPolicy;
use App\Policies\Organizations\OrganizationPolicy;
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
    protected array $policies = [
        Organization::class => OrganizationPolicy::class,
        OrganizationGroup::class => OrganizationGroupPolicy::class,
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
