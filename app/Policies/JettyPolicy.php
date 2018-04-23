<?php

namespace App\Policies;

use App\User;
use App\Jetty;
use App\Authorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class JettyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the jetty.
     *
     * @param  \App\User  $user
     * @param  \App\Jetty  $jetty
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'Jetty')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
    }

    /**
     * Determine whether the user can create jettys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'Jetty')
                ->where('user_id', $user->id)
                ->where('create', 1)->count();
    }

    /**
     * Determine whether the user can update the jetty.
     *
     * @param  \App\User  $user
     * @param  \App\Jetty  $jetty
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'Jetty')
                ->where('user_id', $user->id)
                ->where('update', 1)->count();
    }

    /**
     * Determine whether the user can delete the jetty.
     *
     * @param  \App\User  $user
     * @param  \App\Jetty  $jetty
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'Jetty')
                ->where('user_id', $user->id)
                ->where('delete', 1)->count();
    }
}
