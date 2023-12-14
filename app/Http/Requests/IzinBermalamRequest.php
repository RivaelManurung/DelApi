<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IzinBermalamRequest extends FormRequest
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
            'content' => 'required|string|min:6',
            'rencana_berangkat' => 'required',
            'rencana_kembali' => 'required',
        ];
    }

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
