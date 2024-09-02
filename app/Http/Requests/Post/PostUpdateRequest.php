<?php

namespace App\Http\Requests\Post;

use App\Http\Api\ApiRequest;
use Faker\Core\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends ApiRequest
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
        $postId = $this->route('id');
        return [
            "title" => ['sometimes', "required"],
            "description" => ['sometimes', "required"],
            "slug" => ['sometimes', "required", Rule::unique("posts", "slug")->ignore($postId)],
            "photos.*" => ['sometimes', "file", \Illuminate\Validation\Rules\File::image()],
            "category_id" => ['sometimes', Rule::exists("categories", "id")],
            "status" => ['sometimes', "required"]
        ];
    }
}
