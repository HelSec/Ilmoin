<?php

namespace App\Providers;

use App\Organizations\Events\Event;
use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
use App\Policies\Organizations\EventPolicy;
use App\Policies\Organizations\OrganizationGroupPolicy;
use App\Policies\Organizations\OrganizationPolicy;
use App\Users\MattermostSocialiteProvider;
use App\Users\User;
use Illuminate\Contracts\Container\BindingResolutionException;
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
        Organization::class => OrganizationPolicy::class,
        OrganizationGroup::class => OrganizationGroupPolicy::class,
        Event::class => EventPolicy::class,
    ];

    /**
     * These capabilities aren't overridden by the `is_super_admin` user attribute
     *
     * @var string[]
     */
    protected $noAdminOverride = [
        'join',
        'attend',
        'cancel',
        'confirm',
    ];

    /**
     * These capabilities aren't overridden by global Ilmoin blocks.
     *
     * @var string[]
     */
    public $noBlockOverride = [
        'view',
        'viewMembers',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user, $ability) {
            if ($user->activeBlock && !in_array($ability, $this->noBlockOverride)) {
                return false;
            }

            if ($user->is_super_admin && !in_array($ability, $this->noAdminOverride)) {
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
