<?php

namespace App\Http\Controllers\IzinKeluar;

use App\Http\Controllers\Controller;
use App\Http\Requests\IzinKeluarRequest;
use App\Models\IzinKeluar;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $izins = IzinKeluar::with('user')->latest()->get();
        return response([
            'izins' => $izins
        ], 200);
    }

    public function store(IzinKeluarRequest $request)
    {
        $request->validated();

        auth()->user()->izinkeluar()->create([
            'content' => $request->content,
            'rencana_berangkat' => $request->rencana_berangkat,
            'rencana_kembali' => $request->rencana_kembali,
        ]);

        return response([
            'message' => 'Izin keluar berhasil diajukan.',
        ], 201);
    }

    public function destroy($id)
    {
        $izin = IzinKeluar::find($id);

        if (!$izin) {
            return response([
                'message' => 'Izin keluar tidak ditemukan.',
            ], 404);
        }

        $izin->delete();

        return response([
            'message' => 'Izin keluar berhasil dihapus.',
        ], 200);
    }
}
