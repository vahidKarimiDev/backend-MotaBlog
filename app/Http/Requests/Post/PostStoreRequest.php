<?php

namespace App\Http\Requests\Post;

use App\Http\Api\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ['required'],
            "description" => ['required'],
            "miniDesc" => ['required'],
            "photos.*" => ['required', "file"],
            "slug" => ['required', Rule::unique("posts", "slug")],
            "category_id" => ['required', Rule::exists("categories", "id")],
            "admin_id" => ['required', Rule::exists("admin", 'id')],
        ];
    }
}
