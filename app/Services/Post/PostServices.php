<?php

namespace App\Services\Post;

use App\Base\ServiceResult;
use App\Http\Resources\Post\GetAllPostResource;
use App\Http\Resources\Post\ShowPostResource;
use App\Models\Post;
use http\Env\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class PostServices
{
    public function getAllPost($request): ServiceResult
    {
        try {
            $offset = $request->input('offset');
            $posts = Post::where("status", true)->with(["admin", "category"])->skip($offset)->take(6)->get();
            foreach ($posts as $post) {
                $post->photos = $this->changePathToUrl(json_decode($post->photos, true));
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
                foreach ($request->file("photos") as $file) {
                    $path = $file->store("Photos");
                    $paths[] = $path;
                }
            }

            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->miniDesc = $request->miniDesc;
            $post->slug = $request->slug;
            $post->photos = json_encode($paths);
            $post->category_id = $request->category_id;
            $post->admin_id = $request->admin_id;
            $post->status = $request->status;
            $post->save();

            return new ServiceResult(ok: true, data: $post, status: 201);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
    }

    public function showOnePost(string $slug): ServiceResult
    {
        try {
            $post = Post::with(['admin', "category"])->where("slug", $slug)->firstOrFail();
            $lastPost = Post::where("slug", "!=", $slug)->orderBy("created_at", "desc")->limit(3)->select("title", 'slug', 'photos')->get();

            foreach ($lastPost as $itemPost) {
                $photos = json_decode($itemPost->photos, true);
                $urlPhotos = $this->changePathToUrl($photos);
                $itemPost['photo'] = $urlPhotos[0] ?? null;
            }

            $post['last_post'] = $lastPost;
            $post->photos = $this->changePathToUrl(json_decode($post->photos, true));
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "post Not A Found :)", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: ShowPostResource::make($post), status: 200);
    }

    public function updatePost($request, string $id): ServiceResult
    {
        try {
            $post = Post::findOrFail($id);

            $paths = [];
            if ($request->hasFile("photos")) {
                $files = $request->file("photos");
                foreach ($files as $file) {
                    $path = $file->store("Photos");
                    $paths[] = $path;
                }
            }

            $data = $request->only([
                "title",
                "description",
                "miniDesc",
                "slug",
                "category_id",
                "status",
            ]);

            if (!empty($paths)) {
                $data['photos'] = json_encode($paths);
            }
            $post->update($data);
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "Post Not A Found :)", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }

        return new ServiceResult(ok: true, data: $post, status: 200);
    }

    public function deletePost(string $id): ServiceResult
    {
        try {
            $post = Post::findOrFail($id);
            foreach (json_decode($post->photos, true) as $photo) {
                Storage::delete($photo);
            }
            $post->delete();
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "Post Not A Found :(", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: [], status: 204);
    }


    public function uploadImage($request): ServiceResult
    {
        try {
            $url = null;
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $path = $file->store("Photos");
                $url = Storage::url($path);
            }
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: ["url" => $url, "uploaded" => "success"], status: 201);
    }


    protected function changePathToUrl($paths)
    {
        $urls = [];
        foreach ($paths as $path) {
            $urls[] = Storage::url($path);
        }
        return $urls;
    }
}
