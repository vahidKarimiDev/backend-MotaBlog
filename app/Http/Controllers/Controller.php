<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 * title="Mota Blog",
 * version="1.0.0"
 *  )
 * @OA\Tag(
 *     name="Auth 🔒"
 *  ),
 * @OA\Tag(
 *      name="Admin 👨‍💼"
 *  ),
 * @OA\Tag(
 *  name="Post 📃"
 *  ),
 * @OA\Tag(
 *      name="Contact 🤝"
 *  ),
 * @OA\Tag(
 *      name="Category 🔴"
 *  )
 * */
abstract class Controller extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
}
