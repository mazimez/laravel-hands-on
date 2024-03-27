<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class PostIndexRequest extends FormRequest
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
            'page' => 'numeric|gt:0',
            'per_page' => 'numeric|gt:0',
            'search' => '',
            'sort_field' => '',
            'sort_order' => 'in:asc,desc,ASC,DESC',
            'user_id' => 'exists:users,id'
        ];
    }
}
