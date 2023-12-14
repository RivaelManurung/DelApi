<?php

namespace App\Http\Controllers\izinbermalam;

use App\Http\Controllers\Controller;
use App\Http\Requests\IzinBermalamRequest;
use App\Models\IzinBermalam;
use Illuminate\Http\Request;
use App\Rules\ValidRencanaDateTime;

class izinbemalamController extends Controller
{
    public function index()
    {
        $izinBermalam = IzinBermalam::with('user')->latest()->get();
        return response([
            'izinBermalam' => $izinBermalam
        ], 200);
    }

    public function store(IzinBermalamRequest $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:6',
            'rencana_berangkat' => ['required', new ValidRencanaDateTime],
            'rencana_kembali' => 'required',
        ]);

        auth()->user()->izinBermalam()->create([
            'content' => $request->content,
            'rencana_berangkat' => $request->rencana_berangkat,
            'rencana_kembali' => $request->rencana_kembali,
        ]);

        return response([
            'message' => 'Izin bermalam berhasil diajukan.',
        ], 201);
    }

    public function destroy($id)
    {
        $ib = IzinBermalam::find($id);

        if (!$ib) {
            return response([
                'message' => 'Izin bermalam tidak ditemukan.',
            ], 404);
        }

        $ib->delete();
        
        return response([
            'message' => 'Izin bermalam berhasil dihapus.',
        ], 200);
    }
}
