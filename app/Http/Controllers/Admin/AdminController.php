<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\RestApi\Facade\ApiResponse;
use App\Services\Admin\AdminServices;

class AdminController extends Controller
{
    protected $adminServices;

    public function __construct(AdminServices $adminServices)
    {
        $this->adminServices = $adminServices;

        $this->middleware("auth:sanctum");
    }

    /**
     * @OA\Get(
     *     path="/admin",
     *     tags={"Admin 👨‍💼"},
     *     summary="Get All Admins",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get All Admins",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="userName",
     *                         type="string",
     *                         example="mona"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="mona@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         type="string",
     *                         example="09150300174"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="date"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $admins = $this->adminServices->getAllAdmin();
        return ApiResponse::withData($admins)->build()->response();
    }

    /**
     * @OA\Post(
     *     path="/admin",
     *     tags={"Admin 👨‍💼"},
     *     summary="Create New Admin",
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
     *                     property="userName",
     *                     type="string",
     *                     example="vahid karimi"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="09150300174"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="vahid..0101"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Admin created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Create User Success Fully :)"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="userName",
     *                     type="string",
     *                     example="vahid karimi"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="09150300174"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function store(AdminStoreRequest $request)
    {
        $result = $this->adminServices->createAdmin($request);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withMessage("Create User Success Fully :)")->withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * @OA\Get(
     *     path="/admin/{admin_id}",
     *     tags={"Admin 👨‍💼"},
     *     summary="Get One Admin",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get One Admin",
     *         @OA\JsonContent(
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=1
 *                 ),
 *                 @OA\Property(
 *                     property="userName",
 *                     type="string",
 *                     example="mona"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     example="mona@gmail.com"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string",
 *                     example="09150300174"
 *                 ),
 *                 @OA\Property(
 *                     property="created_at",
 *                     type="string",
 *                     example="date"
 *                 )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $admin = $this->adminServices->showAdmin($id);
        if (!$admin->ok) {
            return ApiResponse::withMessage($admin->data)->withStatus($admin->status)->build()->response();
        }
        return ApiResponse::withData($admin->data)->build()->response();
    }
    /**
     * @OA\Put(
     *     path="/admin/{admin_id}",
     *     tags={"Admin 👨‍💼"},
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
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="userName",
     *                     type="string",
     *                     example="vahid karimi"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="09150300174"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="vahid..0101"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated Admin Success Fully :))",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Update Admin Success Fully :)"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="userName",
     *                     type="string",
     *                     example="vahid karimi"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="09150300174"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function update(AdminUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $result = $this->adminServices->updateAdmin($data, $id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->build()->response();
    }

    /**
     * @OA\Delete(
     *     path="/admin/{admin_id}",
     *     tags={"Admin 👨‍💼"},
     *     summary="Delete Admin ",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Delete Admin Success Fully :))",
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $result = $this->adminServices->deleteAdmin($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withMessage("")->withStatus($result->status)->build()->response();
    }
}
