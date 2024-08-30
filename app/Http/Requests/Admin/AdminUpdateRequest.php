<?php

namespace App\Http\Requests\Admin;

use App\Http\Api\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends ApiRequest
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
        $adminid = $this->route("adminId");
        return [
            "userName" => ["sometimes", 'required', Rule::unique("admin", "userName")->ignore($adminid)],
            "email" => ["sometimes", 'required', "email", Rule::unique("admin", "email")->ignore($adminid)],
            "phone" => ["sometimes", 'required', "max:11", Rule::unique("admin", "phone")->ignore($adminid)],
            "password" => ["sometimes", 'required'],
        ];
    }
}
