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
     * @OA\Get(
     *     path="/contact",
     *     tags={"Contact 🤝"},
     *     summary="Get All Contact",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get All Contact",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="userName",
     *                         type="string",
     *                         example="mona"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="mona@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="subject",
     *                         type="string",
     *                         example="test subject"
     *                     ),
     *                     @OA\Property(
     *                         property="text",
     *                         type="text",
     *                         example="text ..."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/contact",
     *     tags={"Contact 🤝"},
     *     summary="Create New Contact",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="userName",
     *                     type="string",
     *                     example="vahid karimi"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="vahid@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="subject",
     *                     type="string",
     *                     example="test"
     *                 ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="text",
     *                     example="text"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Create New Contact :)",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Create Contact Success Fully :)"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
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
     * @OA\Get(
     *     path="/contact/{contact_id}",
     *     tags={"Contact 🤝"},
     *     summary="Get One Contact",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get One Contact",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="userName",
     *                         type="string",
     *                         example="mona"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="mona@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="subject",
     *                         type="string",
     *                         example="test subject"
     *                     ),
     *                     @OA\Property(
     *                         property="text",
     *                         type="text",
     *                         example="text ..."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/contact/{contact_id}",
     *     tags={"Contact 🤝"},
     *     summary="Delete Contact ",
     *     security={{"sanctum" : {}}},
     *     @OA\Parameter(
     *         name="Token",
     *         in="header",
     *         required=true,
     *         example="Token Admin"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Delete Contact Success Fully :))",
     *     )
     * )
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
