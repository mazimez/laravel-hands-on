<?php

namespace App\Http\Requests\Api\v1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if ($this->has('is_blocked') || $this->has('is_verified')) {
            if (!$user || $user->type != User::ADMIN) {
                throw new \Exception(__('messages.only_admin_can_use_this_filter'));
            }
        }
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
            'page' => 'numeric|gt:0',
            'per_page' => 'numeric|gt:0',
            'search' => '',
            'sort_field' => '',
            'sort_order' => 'in:asc,desc,ASC,DESC',
            'user_id' => 'exists:users,id',
            'is_blocked' => 'in:1,0',
            'is_verified' => 'in:1,0',
        ];
    }
}
