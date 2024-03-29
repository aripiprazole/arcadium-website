<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RoleStoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public final function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public final function rules()
  {
    return [
      'title' => 'required|string|max:32',
      'color' => 'required|string|max:32',
      'permission_level' => 'required|numeric',
    ];
  }
}
