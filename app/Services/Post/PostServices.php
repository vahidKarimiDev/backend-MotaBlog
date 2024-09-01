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


    public function createPost($request): ServiceResult
    {
        try {
            $paths = [];

            if ($request->hasFile("photos")) {
                foreach ($request->file("photos") as $key => $file) {
                    $path = $file->store("Photos");
                    $paths[] = Storage::url($path);
                }
            }

            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->slug = $request->slug;
            $post->photos = json_encode($paths);
            $post->category_id = $request->categories_id;
            $post->admin_id = $request->admin_id;
            $post->save();

            return new ServiceResult(ok: true, data: $post, status: 201);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
    }


}
