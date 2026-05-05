<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->name,
            'email' => $this->email,
            'profile' => $this->profile,
            'profile_info' => ProfileResource::make($this->whenLoaded('profileInfo')),
            'posts'=> PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
