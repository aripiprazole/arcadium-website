<?php

namespace App\Observers;

use App\Repositories\RoleRepository;
use App\Role;

/**
 * Class RoleObserver
 *
 * @package App\Observers
 */
final class RoleObserver
{

  private RoleRepository $roleRepository;

  /**
   * RoleObserver constructor
   *
   * @param RoleRepository $roleRepository
   */
  public final function __construct(RoleRepository $roleRepository)
  {
    $this->roleRepository = $roleRepository;
  }

  /**
   * Handle the role "created" event.
   *
   * @param Role $role
   * @return void
   */
  public final function created(Role $role)
  {
    $this->roleRepository->flushCache();
  }

  /**
   * Handle the role "updated" event.
   *
   * @param Role $role
   * @return void
   */
  public final function updated(Role $role)
  {
    $this->roleRepository->flushCache();
  }

  /**
   * Handle the role "deleted" event.
   *
   * @param Role $role
   * @return void
   */
  public final function deleted(Role $role)
  {
    $this->roleRepository->flushCache();
  }
}
