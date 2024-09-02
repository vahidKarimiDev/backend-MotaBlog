<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\RestApi\Facade\ApiResponse;
use App\Services\Post\PostServices;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{

    protected PostServices $postServices;

    public function __construct(PostServices $postServices)
    {
        $this->postServices = $postServices;

//        $this->middleware("auth:sanctum")->except(['index', "show"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->postServices->getAllPost();
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $result = $this->postServices->createPost($request);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->postServices->showOnePost($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }

        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id)
    {
        $result = $this->postServices->updatePost($request, $id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
