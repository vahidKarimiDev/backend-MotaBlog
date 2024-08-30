<?php

namespace App\Services;

use App\Models\Admin;
use App\RestApi\Facade\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AdminServices
{
    public function getAllAdmin()
    {
        $admins = Admin::where("verify_phone", true)->get();
        return $admins;
    }

    public function createAdmin(array $request)
    {
        try {
            $request['password'] = Hash::make($request['password'], [
                "driver" => "argon2id"
            ]);
            $result = Admin::create($request);
        } catch (\Throwable $err) {
            return ApiResponse::withMessage($err->getMessage())->withStatus(500)->build()->response();
        }
        return $result;
    }

    public function showAdmin(string $id)
    {
        try {
            $admin = Admin::find($id);

        } catch (\Throwable $err) {
            return ApiResponse::withMessage($err->getMessage())->withStatus(500)->build()->response();
        }

        return $admin;
    }


}
