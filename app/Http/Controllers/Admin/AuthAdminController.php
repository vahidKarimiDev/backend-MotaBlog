<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\RestApi\Facade\ApiResponse;
use App\Services\Admin\AuthServices;
use Illuminate\Http\Request;
use mysql_xdevapi\Result;

class AuthAdminController extends Controller
{
    protected AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;

        $this->middleware("guest");
    }
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth 🔒"},
     *     summary="Login",
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
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
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
     *         description="Login Success Fully :))",
     *         @OA\JsonContent(
 *                 @OA\Property(
 *                     property="token",
 *                     type="string",
 *                     example="admin Token"
 *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function __invoke(AdminLoginRequest $request)
    {
        $data = $request->only(["email", "password"]);
        $result = $this->authServices->login($data);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData(["token" => $result->data])->withStatus($result->status)->build()->response();
    }
}
