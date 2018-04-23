<?php

namespace App\Policies;

use App\User;
use App\ProblemProductivityCategory;
use App\Authorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemProductivityCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the problemProductivityCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ProblemProductivityCategory  $problemProductivityCategory
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'ProblemProductivityCategory')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
    }

    /**
     * Determine whether the user can create problemProductivityCategorys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'ProblemProductivityCategory')
                ->where('user_id', $user->id)
                ->where('create', 1)->count();
    }

    /**
     * Determine whether the user can update the problemProductivityCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ProblemProductivityCategory  $problemProductivityCategory
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'ProblemProductivityCategory')
                ->where('user_id', $user->id)
                ->where('update', 1)->count();
    }

    /**
     * Determine whether the user can delete the problemProductivityCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ProblemProductivityCategory  $problemProductivityCategory
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'ProblemProductivityCategory')
                ->where('user_id', $user->id)
                ->where('delete', 1)->count();
    }
}
