<?php

namespace App\Http\Controllers\PembelianKaos;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\pembeliankaosRequest;
use App\Models\pembelian_kaos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class pembeliankaosController extends Controller
{
    public function index()
    {
        $pembelianKaos = pembelian_kaos::with('user')->latest()->get();
        
        return response([
            'pembelianKaos' => $pembelianKaos
        ],200);
    }


    public function store(pembeliankaosRequest $request){
        $request->validated();

        auth()->user()->pembelian_kaos()->create([
            'price' => $request->price,
            'size' => $request->size,
        ]);

        return response([
            'message' => 'Pembelian kaos berhasil diajukan'
        ],201);

    }

    public function destroy($id){
        $pembelianKaos = pembelian_kaos::find($id);

        if (!$pembelianKaos) {

            return response([
                'message' => 'Pembelian kaos tidak ditemukan',
            ],404);
        }

        $pembelianKaos->delete();

        return response([
            'message' => 'Izin keluar berhasil dihapus',
        ],200);
    }


    public function update(Request $request, pembelian_kaos $pembelian_kaos)
    {
        $this->validate($request, [
            'price' => 'sometimes|required',
        ]);
    
        $pembelian_kaos->update([
            'price' => $request->price,
        ]);
    
        return response([
            'message' => 'pesanan dalam proses',
        ], 200);
    }
    
}
