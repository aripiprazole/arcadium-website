<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\ClearXss;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;

final class Kernel extends HttpKernel
{
  /**
   * The application's global HTTP middleware stack.
   *
   * These middleware are run during every request to your application.
   *
   * @var array
   */
  public $middleware = [
    TrustProxies::class,
    HandleCors::class,
    CheckForMaintenanceMode::class,
    ValidatePostSize::class,
    TrimStrings::class,
    ConvertEmptyStringsToNull::class,
  ];

  /**
   * The application's route middleware groups.
   *
   * @var array
   */
  public $middlewareGroups = [
    'web' => [
      SubstituteBindings::class,
    ],

    'api' => [
      'throttle:60,1',
      SubstituteBindings::class,
    ],
  ];

  /**
   * The application's route middleware.
   *
   * These middleware may be assigned to groups or used individually.
   *
   * @var array
   */
  public $routeMiddleware = [
    'auth' => Authenticate::class,
    'auth.basic' => AuthenticateWithBasicAuth::class,
    'bindings' => SubstituteBindings::class,
    'cache.headers' => SetCacheHeaders::class,
    'can' => Authorize::class,
    'password.confirm' => RequirePassword::class,
    'signed' => ValidateSignature::class,
    'throttle' => ThrottleRequests::class,
    'verified' => EnsureEmailIsVerified::class,
    'xss' => ClearXss::class,
  ];
}
