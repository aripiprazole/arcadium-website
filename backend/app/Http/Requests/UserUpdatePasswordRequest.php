<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

final class UserUpdatePasswordRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public final function authorize()
  {
    return Hash::check($this->get('password'), $this->user()->password);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public final function rules()
  {
    return [
      'password' => 'required|string|min:8|max:16',
      'new_password' => 'required|string|min:8|max:16'
    ];
  }

}
