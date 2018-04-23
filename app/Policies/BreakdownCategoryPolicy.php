<?php

namespace App\Policies;

use App\User;
use App\BreakdownCategory;
use App\Authorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class BreakdownCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the breakdownCategory.
     *
     * @param  \App\User  $user
     * @param  \App\BreakdownCategory  $breakdownCategory
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'BreakdownCategory')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
    }

    /**
     * Determine whether the user can create breakdownCategorys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'BreakdownCategory')
                ->where('user_id', $user->id)
                ->where('create', 1)->count();
    }

    /**
     * Determine whether the user can update the breakdownCategory.
     *
     * @param  \App\User  $user
     * @param  \App\BreakdownCategory  $breakdownCategory
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'BreakdownCategory')
                ->where('user_id', $user->id)
                ->where('update', 1)->count();
    }

    /**
     * Determine whether the user can delete the breakdownCategory.
     *
     * @param  \App\User  $user
     * @param  \App\BreakdownCategory  $breakdownCategory
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'BreakdownCategory')
                ->where('user_id', $user->id)
                ->where('delete', 1)->count();
    }

    public function createOrUpdate(User $user)
    {
        return $this->create($user) || $this->update($user);
    }

    public function updateOrDelete(User $user)
    {
        return $this->update($user) || $this->delete($user);
    }
}
