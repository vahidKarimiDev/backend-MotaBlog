<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "photos" => $this->photos,
            "slug" => $this->slug,
            "created_at" => $this->created_at,
            "admin_id" => $this->admin->id,
            "admin_userName" => $this->admin->userName,
            "category" => $this->category->title,
        ];
    }
}
