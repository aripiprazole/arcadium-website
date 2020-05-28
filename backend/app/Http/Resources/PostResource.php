<?php

namespace App\Http\Resources;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostResource
 * @package App\Http\Resources
 *
 * @property int id
 * @property string title
 * @property string description
 * @property int likes
 * @property User user
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PostResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'likes' => $this->likes,
      'created_by' => route('users.show', [
        'user' => $this->user->id
      ]),
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}