<?php

namespace App\Http\Controllers\Baak;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Baak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BaakController extends Controller
{
    public function register(LoginRequest $request)
    {
        $request->validated();

        $baakData = [
            'nomor_ktp' => $request->nomor_ktp,
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_handphone' => $request->nomor_handphone,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $baak = Baak::create($baakData);
        $token = $baak->createToken('delapi')->plainTextToken;

        return response([
            'baak' => $baak,
            'token' => $token
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $request->validated();

        $baak = Baak::whereName($request->name)->first();
        if (!$baak || !Hash::check($request->password, $baak->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 422);
        }

        $token = $baak->createToken('delapi')->plainTextToken;

        return response([
            'baak' => $baak,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Successfully logged out'
        ]);
    }
}
