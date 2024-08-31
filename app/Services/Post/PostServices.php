<?php

namespace App\Services\Post;

use App\Base\ServiceResult;
use App\Http\Resources\Post\GetAllPostResource;
use App\Models\Post;

class PostServices
{

    public function getAllPost(): ServiceResult
    {
        try {
            $posts = Post::all()->load(["admin", "category"]);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: GetAllPostResource::collection($posts), status: 200);
    }


}
