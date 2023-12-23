<?php

namespace App\Http\Controllers\IzinKeluar;
use App\Http\Middleware\IsBaakMiddleware;
use App\Http\Controllers\Controller;
use App\Http\Requests\IzinKeluarRequest;
use App\Models\IzinKeluar;

class IzinKeluarController extends Controller
{

    public function index()
    {
        // Mendapatkan izin keluar hanya untuk pengguna yang sedang login
        $izins = auth()->user()->izinkeluar()->with('user')->latest()->get();

        return response([
            'izins' => $izins
        ], 200);
    }
    public function getAllIzinKeluar()
    {
        try {
            $izinkeluar = izinkeluar::all(); // You can modify this based on your requirements
            return response()->json(['izinsadmin' => $izinkeluar], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
    public function updateStatus($id, $status)
    {
        $this->middleware(IsBaakMiddleware::class);
        $izin = IzinKeluar::find($id);

        if (!$izin) {
            return response([
                'message' => 'Izin keluar tidak ditemukan.',
            ], 404);
        }

        // Validasi status yang diperbolehkan
        if (!in_array($status, ['pending', 'accepted', 'rejected'])) {
            return response([
                'message' => 'Status yang dimasukkan tidak valid.',
            ], 400);
        }

        // Set status izin
        $izin->status = $status;
        $izin->save();

        return response([
            'message' => 'Status izin keluar berhasil diperbarui.',
        ], 200);
    }
}
