<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuratRequest;
use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{

    public function index()
    {
        $surats = Surat::with('user')->latest()->get();
        return response([
            'surats' => $surats
        ], 200);
    }

    public function store(SuratRequest $request)
    {
        $request->validated();

        auth()->user()->surats()->create([
            'content' => $request->content
        ]);

        return response([
            'message' => 'success',
        ], 201);
    }


    
}
