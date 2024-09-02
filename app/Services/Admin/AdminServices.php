<?php

namespace App\Services\Admin;

use App\Base\ServiceResult;
use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminServices
{
    public function getAllAdmin()
    {
        $admins = Admin::where("verify_phone", true)->get();
        return $admins;
    }

    public function createAdmin(array $request): ServiceResult
    {
        try {
            $profileUrl = "https://avatar.iran.liara.run/public/29";
            $admin = new Admin();

            if ($request->hasFile("profile")) {
                $path = $request->file("profile")->store("AdminProfile");
                $profileUrl = Storage::url($path);
            }
            $request['password'] = Hash::make($request['password'], [
                "driver" => "argon2id"
            ]);

            $admin->userName = $request->userName;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $admin->profile = $profileUrl;
            $admin->description = $request->description;
            $admin->password = $request->password;
            $admin->save();

        } catch (\Throwable $err) {
            return new ServiceResult(false, $err->getMessage(), 500);
        }
        return new ServiceResult(true, $admin, 201);
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
