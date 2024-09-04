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
     * @OA\Put(
     *     path="/blog/{blog_id}",
     *     tags={"Post 📃"},
     *     summary="Update Admin",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Parameter(
     *         name="Show Error",
     *         in="header",
     *         required=true,
     *         example="Accept = application/json"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="title ... "
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="description"
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="slug"
     *                 ),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="array",
     *                 @OA\Items(
     *                      type="string",
     *                      example="File Image"
     *                 )
     *               ),
 *                    @OA\Property(
     *                      property="category_id",
     *                      type="integer",
     *                      example="1"
     *                 ),
     *                 @OA\Property(
     *                      property="status",
     *                      type="boolean",
     *                      example="true Or False"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated Admin Success Fully :))",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/post/{post_id}",
     *     tags={"Post 📃"},
     *     summary="Delete Post ",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Delete Post Success Fully :))",
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $result = $this->postServices->deletePost($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }
}
