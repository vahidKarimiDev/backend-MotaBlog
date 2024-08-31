<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\RestApi\Facade\ApiResponse;
use App\Services\Post\PostServices;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected PostServices $postServices;

    public function __construct(PostServices $postServices)
    {
        $this->postServices = $postServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->postServices->getAllPost();
        return ApiResponse::withData($result)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
