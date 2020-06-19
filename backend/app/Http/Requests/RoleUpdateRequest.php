<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RoleUpdateRequest extends FormRequest
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
      'title' => 'string|max:32',
      'color' => 'string|max:12',
      'is_staff' => 'boolean',
    ];
  }
}
