<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterBaakRequest extends FormRequest
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
            'nomor_ktp' => 'nullable|string',
            'nim' => 'nullable|string',
            'nama_lengkap' => 'nullable|string',
            'nomor_handphone' => 'nullable|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:baaks,email',
            'password' => 'required|min:8',
            'user_id' => 'required|exists:users,id', // Assuming users table exists
        ];
    }
}
