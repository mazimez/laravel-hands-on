<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'meta_data' => 'json',
            'files.*' => 'file|mimetypes:video/*,image/*',
            'files' => 'array',
            'description' => 'required',
            'title' => 'required',
            'tag_ids.*' => 'exists:tags,id',
            'tag_ids' => 'array|max:5',
        ];
    }
}
