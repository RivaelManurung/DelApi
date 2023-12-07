<?php

namespace App\Http\Controllers\IzinKeluar;

use App\Http\Controllers\Controller;
use App\Http\Requests\IzinKeluarRequest;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

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
}
