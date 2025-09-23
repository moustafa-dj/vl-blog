<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'bio' => $this->bio,
            'nb_following' => $this->nb_following,
            'nb_followers' => $this->nb_followers,
            'social_links' => $this->social_links,
            'user' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
