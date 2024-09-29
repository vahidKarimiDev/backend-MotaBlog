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
     * @OA\Get(
     *     path="/blog",
     *     tags={"Post 📃"},
     *     summary="Get All Blog",
     *     @OA\Response(
     *         response=200,
     *         description="Get All Blog",
     *         @OA\JsonContent(
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="test title"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="description"
     *                     ),
     *                     @OA\Property(
     *                         property="slug",
     *                         type="string",
     *                         example="mona@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="photos",
     *                         type="array",
     *                         @OA\Items(
     *                      type="string",
     *                      example="Url Image"
    )
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="date"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         example="category name"
     *                     ),
     *                       @OA\Property(
     *                         property="admin_name",
     *                         type="string",
     *                         example="admin name"
     *                     ),
     *                        @OA\Property(
     *                         property="admin_profile",
     *                         type="string",
     *                         example="admin profile"
     *                     )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $result = $this->postServices->getAllPost($request);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * @OA\Post(
     *     path="/blog",
     *     tags={"Post 📃"},
     *     summary="Create Blog",
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
     *                     @OA\Property(
     *                     property="miniDesc",
     *                     type="string",
     *                     example="miniDesc"
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
     *                   @OA\Property(
     *                      property="admin_id",
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
     *         response=201,
     *         description="Create Blog Success Fully :))",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
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
     * @OA\Get(
     *     path="/blog/{blog_id}",
     *     tags={"Post 📃"},
     *     summary="Get One Blog",
     *     @OA\Response(
     *         response=200,
     *         description="Get One Blog",
     *         @OA\JsonContent(
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="test title"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="description"
     *                     ),
     *                     @OA\Property(
     *                         property="slug",
     *                         type="string",
     *                         example="mona@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="photos",
     *                         type="array",
     *                         @OA\Items(
     *                      type="string",
     *                      example="Url Image"
    )
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="date"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         example="category name"
     *                     ),
     *                       @OA\Property(
     *                         property="admin_name",
     *                         type="string",
     *                         example="admin name"
     *                     ),
     *                        @OA\Property(
     *                         property="admin_profile",
     *                         type="string",
     *                         example="admin profile"
     *                     ),
     *                     @OA\Property(
     *                         property="admin_desc",
     *                         type="string",
     *                         example="admin desc"
     *                     ),
     *         )
     *     )
     * )
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
     *     summary="Update Blog",
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
     *                     @OA\Property(
     *                     property="miniDesc",
     *                     type="string",
     *                     example="miniDesc"
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
     *         description="Updated Blog Success Fully :))",
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
     *     path="/blog/{blog_id}",
     *     tags={"Post 📃"},
     *     summary="Delete Blog ",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Delete Blog Success Fully :))",
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

    public function uploadImageCkeditor (Request $request) {
        $result = $this->postServices->uploadImage($request);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }

        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

}
