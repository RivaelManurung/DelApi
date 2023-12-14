<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuratRequest;
use App\Models\Baak;
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

    public function approve($id)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Access the authenticated user
            $user = auth()->user();

            // Check if the user is a 'baak'
            $baak = Baak::where('user_id', $user->id)->first();

            if ($baak) {
                // Perform the approval logic here for 'baak'
                // ...
            } else {
                // Handle unauthorized access for users who are not 'baak'
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Handle the case where the user is not authenticated
            abort(401, 'Unauthenticated.');
        }

        // Rest of your approval logic...
    }

}

