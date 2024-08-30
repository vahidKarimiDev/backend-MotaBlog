<?php

namespace App\Services\Admin;

use App\Base\ServiceResult;
use Illuminate\Support\Facades\Auth;

class AuthServices
{

    public function login(array $data): ServiceResult
    {
        try {
            if (Auth::guard("admin")->attempt($data)) {
                $admin = Auth::guard("admin")->user();
                $token = $admin->createToken("API_TOKEN")->plainTextToken;
                return new ServiceResult(true, $token, 200);
            }
            return new ServiceResult(false, "User Not A registered :(", 409);
        } catch (\Throwable $err) {
            return new ServiceResult(false, $err->getMessage(), 500);
        }
    }


}
