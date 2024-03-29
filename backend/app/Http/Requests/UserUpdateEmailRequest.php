<?php

namespace App\Http\Requests;

use App\Repositories\Tokens\EmailResetTokenRepository;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateEmailRequest
 *
 * @package App\Http\Requests
 */
final class UserUpdateEmailRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public final function authorize()
  {
    /** @var EmailResetTokenRepository $repository */
    $repository = resolve(EmailResetTokenRepository::class);
    $token = $this->query('token', '');

    return $repository->exists($this->user(), $token);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public final function rules()
  {
    return [
      'new_email' => 'required|string|min:8|max:48'
    ];
  }
}
