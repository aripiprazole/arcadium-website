<?php

namespace App\Http\Controllers;

use App\EmailUpdate;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserUpdateEmailRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use Exception;
use Illuminate\Http\Response;

class UserController extends Controller
{
  /**
   * @param UserUpdateRequest $request
   * @return Response
   */
  public function update(UserUpdateRequest $request)
  {
    $request->user()
      ->fill($request->only([
        'name',
        'user_name'
      ]))
      ->save();

    return response()->noContent();
  }

  public function updatePassword(UserUpdatePasswordRequest $request)
  {
    $request->user()
      ->fill([
        'password' => $request->get('new_password')
      ])
      ->save();

    return response()->noContent();
  }

  public function updateEmail(EmailUpdate $email_update, UserUpdateEmailRequest $request)
  {
    $email_update->already_used = true;

    $request->user()
      ->fill([
        'email' => $request->get('new_email')
      ])
      ->save();

    return response()->noContent();
  }

  /**
   * @param UserDeleteRequest $request
   * @return Response
   * @throws Exception
   */
  public function delete(UserDeleteRequest $request)
  {
    $request->user()->delete();

    return response()->noContent();
  }
}
