<?php

namespace App\Http\Controllers\Contact;

use App\RestApi\Facade\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactStoreRequest;
use App\Services\Contact\ContactServices;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    protected ContactServices $contactServices;

    public function __construct(ContactServices $contactServices)
    {
        $this->contactServices = $contactServices;

//        $this->middleware('auth:sanctum')->only(["destroy", "show", "index"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->contactServices->getAllContact();
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->contactServices->createContact($data);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->contactServices->showContact($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->contactServices->deleteContact($id);
        if (!$result->ok) {
            return ApiResponse::withMessage($result->data)->withStatus($result->status)->build()->response();
        }
        return ApiResponse::withData($result->data)->withStatus($result->status)->build()->response();
    }
}
