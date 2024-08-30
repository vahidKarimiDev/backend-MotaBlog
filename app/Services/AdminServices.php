<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Models\Admin;
use App\RestApi\Facade\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function showAdmin(string $id): ServiceResult
    {
        try {
            $admin = Admin::findOrFail($id);
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(false, "Admin Not A Found :(", 404);
        } catch (\Throwable $err) {
            return new ServiceResult(false, $err->getMessage(), 500);
        }
        return new ServiceResult(true, $admin);
    }

    public function updateAdmin(array $data, string $id): ServiceResult
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->update($data);
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(false, "Admin Not A Found :(", 404);
        } catch (\Throwable $err) {
            return new ServiceResult(false, $err->getMessage(), 500);
        }
        return new ServiceResult(true, $admin, 200);
    }

    public function deleteAdmin(string $id): ServiceResult
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(false, "Admin Not A Found :(", 404);
        } catch (\Throwable $err) {
            return new ServiceResult(false, $err->getMessage(), 500);
        }
        return new ServiceResult(true, "", 204);

    }

}
