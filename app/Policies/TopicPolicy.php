<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Topic $topic) {
        return $user->ownsTopic($topic);
    }

    public function destroy(User $user, Topic $topic) {
        return $user->ownsTopic($topic);
    }
}