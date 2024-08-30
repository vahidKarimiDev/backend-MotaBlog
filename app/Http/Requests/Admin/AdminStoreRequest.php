<?php

namespace App\Http\Requests\Admin;

use App\Http\Api\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends ApiRequest
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
            "userName" => ['required', Rule::unique("admin", "userName")],
            "email" => ['required',"email", Rule::unique("admin", "email")],
            "phone" => ['required', 'max:11', Rule::unique("admin", "phone")],
            "password" => ['required', "min:6"],
        ];
    }
}
