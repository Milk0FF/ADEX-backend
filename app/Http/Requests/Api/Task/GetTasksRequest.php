<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;

class GetTasksRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories'    => 'nullable|array',
            'categories.*'  => 'required|integer',
            'price_start'   => 'nullable|integer',
            'price_end'     => 'nullable|integer',
        ];
    }
}
