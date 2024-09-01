<?php

namespace App\Services\Post;

use App\Base\ServiceResult;
use App\Http\Resources\Post\GetAllPostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostServices
{

    public function getAllPost(): ServiceResult
    {
        try {
            $posts = Post::where("status", true)->with(["admin", "category"])->get();
            foreach ($posts as $post) {
                $post->photos = json_decode($post->photos, true);
            }
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: GetAllPostResource::collection($posts), status: 200);
    }





}
