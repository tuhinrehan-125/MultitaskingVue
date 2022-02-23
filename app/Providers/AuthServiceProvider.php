<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\Message;
use App\Models\Invitation;
use App\Models\Design;

use App\Policies\TeamPolicy;
use App\Policies\DesignPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Topic' => 'App\Policies\TopicPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        Design::class => DesignPolicy::class,
        Team::class => TeamPolicy::class,
        // Invitation::class => InvitationPolicy::class,
        // Message::class => MessagePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}