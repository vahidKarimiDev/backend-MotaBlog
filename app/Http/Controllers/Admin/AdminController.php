<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\RestApi\Facade\ApiResponse;
use App\Services\Admin\AdminServices;
use function League\Flysystem\UnableToResolveFilesystemMount;

class AdminController extends Controller
{
    protected $adminServices;

    public function __construct(AdminServices $adminServices)
    {
        $this->adminServices = $adminServices;

        $this->middleware("auth:sanctum");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->adminServices->getAllAdmin();
        return ApiResponse::withData($admins)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
