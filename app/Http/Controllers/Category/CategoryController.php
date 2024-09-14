<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateeRequest;
use App\RestApi\Facade\ApiResponse;
use App\Services\Category\CategoryServices;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryServices $categoryService)
    {
        $this->categoryService = $categoryService;

//        $this->middleware(["auth:sanctum"])->except('index');
    }

    /**
     * @OA\Get(
     *     path="/category",
     *     tags={"Category 🔴"},
     *     summary="Get All Category",
     *     @OA\Response(
     *         response=200,
     *         description="Get All Category",
     *         @OA\JsonContent(
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="test title"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="date"
     *                     ),
     *         )
     *     )
     * )
     */
    public function index()
    {
        $result = $this->categoryService->getAllCategory();
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * @OA\Post(
     *     path="/category",
     *     tags={"Category 🔴"},
     *     summary="Create Category",
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
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Create Category Success Fully :))",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function store(CategoryStoreRequest $request)
    {
        $result = $this->categoryService->createNewCategory($request->validated());
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * @OA\Put (
     *     path="/category/{category_id}",
     *     tags={"Category 🔴"},
     *     summary="Update Category",
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
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Update Category Success Fully :))",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function update(CategoryUpdateeRequest $request, string $id)
    {
        $result = $this->categoryService->updateCategory($request->validated(), $id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * @OA\Delete(
     *     path="/category/{category_id}",
     *     tags={"Category 🔴"},
     *     summary="Delete Category",
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
        $result = $this->categoryService->deleteCategory($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }
}
