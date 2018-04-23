<?php

namespace App\Policies;

use App\User;
use App\UnitCategory;
use App\Authorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unitCategory.
     *
     * @param  \App\User  $user
     * @param  \App\UnitCategory  $unitCategory
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'UnitCategory')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
    }

    /**
     * Determine whether the user can create unitCategorys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'UnitCategory')
                ->where('user_id', $user->id)
                ->where('create', 1)->count();
    }

    /**
     * Determine whether the user can update the unitCategory.
     *
     * @param  \App\User  $user
     * @param  \App\UnitCategory  $unitCategory
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'UnitCategory')
                ->where('user_id', $user->id)
                ->where('update', 1)->count();
    }

    /**
     * Determine whether the user can delete the unitCategory.
     *
     * @param  \App\User  $user
     * @param  \App\UnitCategory  $unitCategory
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->super_admin) {
            return true;
        }

        return Authorization::where('controller', 'UnitCategory')
                ->where('user_id', $user->id)
                ->where('delete', 1)->count();
    }
}
