<?php


namespace App\Repositories;


use App\User;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Log\Logger;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
final class UserRepository
{

  const CACHE_KEY = 'users';

  private Logger $logger;
  private CacheRepository $cacheRepository;

  /**
   * UserRepository constructor
   *
   * @param Logger $logger
   * @param CacheRepository $cacheRepository
   */
  public final function __construct(Logger $logger, CacheRepository $cacheRepository)
  {
    $this->logger = $logger;
    $this->cacheRepository = $cacheRepository;
  }

  /**
   * Find all users in a page
   *
   * @param int $page
   * @return LengthAwarePaginator
   */
  public final function findPaginatedUsers($page)
  {
    $this->logger->info("Retrieving users in page {$page}.");

    return $this->cacheRepository->remember($this->getCacheKey("paginated.$page"), now()->addHour(), function () use ($page) {
      $this->logger->info("Caching users in page {$page}.");

      return User::query()->paginate();
    });
  }

  /**
   * Find all trashed users in a page
   *
   * @param int $page
   * @return LengthAwarePaginator
   */
  public final function findPaginatedTrashedUsers($page)
  {
    $this->logger->info("Retrieving trashed users in page {$page}.");

    return $this->cacheRepository->remember($this->getCacheKey("paginated.$page"), now()->addHour(), function () use ($page) {
      $this->logger->info("Caching trashed users in page {$page}.");

      return User::onlyTrashed()->paginate();
    });
  }

  /**
   * Find user by email
   *
   * @param $email
   * @param bool $includeDeleted
   * @param bool $includeAllThatHaveNotVerifiedEmail
   * @return Builder|Model|object|User
   */
  public final function findUserByEmail($email, $includeDeleted = true, $includeAllThatHaveNotVerifiedEmail = true)
  {
    return $this->newModelQuery($includeDeleted, $includeAllThatHaveNotVerifiedEmail)->where('email', $email)->firstOrFail();
  }

  /**
   * Find user by it's id
   *
   * @param int $id
   * @param bool $includeDeleted
   * @param bool $includeAllThatHaveNotVerifiedEmail
   * @return User
   */
  public final function findUserById($id, $includeDeleted = true, $includeAllThatHaveNotVerifiedEmail = true)
  {
    $this->logger->info("Retrieving user {$id}.");

    return $this->cacheRepository->remember($this->getCacheKey("show.$id"), now()->addHour(), function () use ($includeAllThatHaveNotVerifiedEmail, $includeDeleted, $id) {
      $this->logger->info("Caching user {$id}.");

      return $this->newModelQuery($includeDeleted, $includeAllThatHaveNotVerifiedEmail)->findOrFail($id);
    });
  }

  /**
   * Store user in database
   *
   * @param array $data
   * @return User
   */
  public final function createUser(array $data)
  {
    $this->logger->info("Creating user with email {$data['email']}.");

    return User::create($data);
  }

  /**
   * Remove all keys from cache
   *
   * @return void
   */
  public final function flushCache()
  {
    $this->logger->info("Flushing cache for key {$this->getCacheKey('*')}.");

    $this->cacheRepository->getStore()->flush();
  }

  /**
   * Return cache key for user repository
   *
   * @param string $key
   * @return string
   */
  public final function getCacheKey($key)
  {
    return self::CACHE_KEY . '.' . $key;
  }

  private final function newModelQuery($includeDeleted = true, $includeAllThatHaveNotVerifiedEmail = false): Builder
  {
    $query = $includeDeleted ? User::withTrashed() : User::query();

    if (!$includeAllThatHaveNotVerifiedEmail) $query = $query->whereNotNull('email_verified_at');

    return $query;
  }
}
