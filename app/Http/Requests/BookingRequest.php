<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Sesuaikan dengan kebijakan otorisasi Anda
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_kegiatan' => 'required',
            'rencana_peminjaman' => 'required|date',
            'rencana_berakhir' => 'required|date',
            'ruangan_id' => 'required|exists:ruangans,id',
        ];
    }
}
