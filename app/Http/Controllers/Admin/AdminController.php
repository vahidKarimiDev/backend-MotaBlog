<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Models\Admin;
use App\RestApi\Facade\ApiResponse;
use App\Services\AdminServices;
use Illuminate\Http\Request;
use function League\Flysystem\UnableToResolveFilesystemMount;

class AdminController extends Controller
{

    protected $adminServices;


    public function __construct(AdminServices $adminServices)
    {
        $this->adminServices = $adminServices;
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
        $data = $request->validated();
        $result = $this->adminServices->createAdmin($data);
        return ApiResponse::withData($result)->withMessage("create User Success Fully :)")->withStatus(201)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = $this->adminServices->showAdmin($id);
        if (is_null($admin) && empty($admin)) {
            return ApiResponse::withMessage("Admin Not A Found :(")->withStatus(404)->build()->response();
        }
        return ApiResponse::withData($admin)->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
