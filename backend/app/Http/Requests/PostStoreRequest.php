<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PostStoreRequest extends FormRequest
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
      'title' => 'required|string|max:72',
      'description' => 'required|string|max:6000'
    ];
  }
}
