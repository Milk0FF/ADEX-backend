<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SetUserInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data'    => $validator->errors(),
        ], 400));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'nullable|string',
            'lastname' => 'nullable|string',
            'about' => 'nullable|string',
            'email' => 'nullable|string|email|unique:users',
            'phone' => 'nullable|integer',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'required|integer',
            'employment_type' => 'nullable|integer', //1 - свободен, 2 - занят
        ];
    }
}
