<?php

namespace App\Http\Requests\Api\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
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
            'comment'       => 'required|string',
            'score_type_id' => 'required|integer|exists:score_types,id',
            'task_id'       => 'required|integer|exists:tasks,id',
            'customer_id'   => 'required|integer|exists:users,id',
            'executor_id'   => 'required|integer|exists:users,id',
        ];
    }
}
