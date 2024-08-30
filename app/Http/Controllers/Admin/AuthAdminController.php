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
