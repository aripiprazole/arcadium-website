<?php

namespace App\Policies;

use App\User;
use App\Utils\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PunishmentPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can create models.
   *
   * @param User $user
   * @return mixed
   */
  public function create(User $user)
  {
    return $user->hasPermission(Permission::STORE_PUNISHMENT);
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param User $user
   * @return mixed
   */
  public function update(User $user)
  {
    return $user->hasPermission(Permission::UPDATE_PUNISHMENT);
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param User $user
   * @return mixed
   */
  public function delete(User $user)
  {
    return $user->hasPermission(Permission::DELETE_PUNISHMENT);
  }

}
