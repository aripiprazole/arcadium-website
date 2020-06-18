<?php


namespace App\Repositories;


use App\Payment;
use App\User;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Log\Logger;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PaymentRepository
 *
 * @package App\Repositories
 */
class PaymentRepository
{

  const CACHE_KEY = 'payments';

  private Logger $logger;
  private CacheRepository $cacheRepository;

  /**
   * PostRepository constructor
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
   * Find all user's payments in a page
   *
   * @param User $user
   * @param int $page
   * @return LengthAwarePaginator
   */
  public final function findPaginatedPaymentsForUser($user, $page)
  {
    $this->logger->info("Retrieving user {$user->id}'s payments in page {$page}.");

    return $this->cacheRepository->remember($this->getCacheKey("for.$user.paginated.$page"), now()->addHour(), function () use ($user, $page) {
      $this->logger->info("Caching user {$user->id}'s payments in page {$page}.");

      return $user->payments()->paginate();
    });
  }

  /**
   * Find payment by it's id
   *
   * @param int $id
   * @return User
   */
  public final function findPaymentById($id)
  {
    $this->logger->info("Retrieving payment {$id}.");

    return $this->cacheRepository->remember($this->getCacheKey("show.$id"), now()->addHour(), function () use ($id) {
      $this->logger->info("Caching payment {$id}.");

      return Payment::findOrFail($id);
    });
  }

  /**
   * Create payment in database
   *
   * @param User $user
   * @param array $data
   * @return Model
   */
  public final function createPayment(User $user, array $data)
  {
    $this->logger->info("Creating payment for user {$user->id}.");

    return $user->payments()->create($data);
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
   * Return cache key for payment repository
   *
   * @param string $key
   * @return string
   */
  public final function getCacheKey(string $key)
  {
    return self::CACHE_KEY . '.' . $key;
  }
}