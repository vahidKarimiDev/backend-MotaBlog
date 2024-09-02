<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function League\Flysystem\UnableToResolveFilesystemMount;

class ShowPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "slug" => $this->slug,
            "photos" => $this->photos,
            "created_at" => $this->created_at,
            "category" => $this->category->title,
            "admin_name" => $this->admin->userName,
            "admin_profile" => $this->admin->profile,
            "admin_desc" => $this->admin->description,
        ];
    }
}
