<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SetExecutorRequest extends FormRequest
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
            'executor_id' => 'required|integer|exists:users,id',
        ];
    }
}
