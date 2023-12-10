<?php

namespace App\Http\Controllers\Ruangan;

use App\Http\Controllers\Controller;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua ruangan
        $ruangans = Ruangan::all();

        return response([
            'ruangans' => $ruangans
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi request
        $this->validate($request, [
            'nama_ruangan' => 'required'
        ]);

        // Membuat ruangan baru
        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return response([
            'message' => 'Ruangan berhasil dibuat.',
            'ruangan' => $ruangan
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function show(Ruangan $ruangan)
{
    return response([
        'ruangan' => $ruangan
    ], 200);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        // Validasi request
        $this->validate($request, [
            'nama_ruangan' => 'required'
        ]);

        // Mengupdate ruangan
        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return response([
            'message' => 'Ruangan berhasil diupdate.',
            'ruangan' => $ruangan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return response([
            'message' => 'Ruangan berhasil dihapus.'
        ], 200);
    }
    public function getById($id)
    {
        // Mengambil ruangan berdasarkan ID
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response([
                'message' => 'Ruangan tidak ditemukan.'
            ], 404);
        }

        return response([
            'ruangan' => $ruangan
        ], 200);
    }

}
