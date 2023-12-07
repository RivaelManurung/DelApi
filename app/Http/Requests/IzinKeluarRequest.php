<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IzinKeluarRequest extends FormRequest
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
            'content' => 'required|string|min:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'user_id.exists' => 'The selected user ID is invalid.',
            'content.required' => 'Content is required.',
            'content.string' => 'Content must be a string.',
            'content.min' => 'Content must be at least :min characters.',
        ];
    }
}
