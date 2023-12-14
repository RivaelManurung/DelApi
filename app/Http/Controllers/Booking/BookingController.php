<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Baak;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        
        $userBookings = Auth::user()->bookings()->with('user', 'ruangan')->get();

        return response([
            'bookings' => $userBookings
        ], 200);
    }

    public function store(Request $request)
    {
        // Validasi request
        $this->validate($request, [
            'nama_kegiatan' => 'required',
            'rencana_peminjaman' => 'required|date',
            'rencana_berakhir' => 'required|date',
            'ruangan_id' => 'required|exists:ruangans,id',
            
        ]);

        // Cek apakah ruangan sudah di-booking pada waktu yang sama
        $existingBooking = Booking::where('ruangan_id', $request->ruangan_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('rencana_peminjaman', [$request->rencana_peminjaman, $request->rencana_berakhir])
                    ->orWhereBetween('rencana_berakhir', [$request->rencana_peminjaman, $request->rencana_berakhir]);
            })
            ->first();

        if ($existingBooking) {
            return response([
                'message' => 'Ruangan telah di-booking pada waktu yang sama.'
            ], 422); // Kode 422 untuk Unprocessable Entity
        }

        // Membuat booking baru
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'nama_kegiatan' => $request->nama_kegiatan,
            'rencana_peminjaman' => $request->rencana_peminjaman,
            'rencana_berakhir' => $request->rencana_berakhir,
            'ruangan_id' => $request->ruangan_id,
            'status'=> 'pending'
        ]);

        return response([
            'message' => 'Booking berhasil dibuat.',
            'booking' => $booking
        ], 201);
    }


    public function destroy($id)
    {
        // Menghapus booking berdasarkan ID
        $booking = Booking::find($id);

        if (!$booking) {
            return response([
                'message' => 'Booking tidak ditemukan.'
            ], 404);
        }

        $booking->delete();

        return response([
            'message' => 'Booking berhasil dihapus.'
        ], 200);
    }

    // public function approveBooking($id)
    // {
    //     // Find the booking by ID
    //     $booking = Booking::find($id);

    //     if (!$booking) {
    //         return response([
    //             'message' => 'Booking not found.'
    //         ], 404);
    //     }

    //     // Check if the authenticated user is a Baak
    //     $baak = Auth::user()->baak;

    //     if (!$baak) {
    //         return response([
    //             'message' => 'You do not have permission to approve bookings.'
    //         ], 403); // HTTP status code 403 for Forbidden
    //     }

    //     // Check if the booking is associated with the Baak
    //     if ($booking->baak_id !== $baak->id) {
    //         return response([
    //             'message' => 'You do not have permission to approve this booking.'
    //         ], 403); // HTTP status code 403 for Forbidden
    //     }

    //     // Check if the booking is in a pending state
    //     if ($booking->status !== 'pending') {
    //         return response([
    //             'message' => 'Booking is not in a pending state and cannot be approved.'
    //         ], 422);
    //     }

    //     // Approve the booking
    //     $booking->status = 'approved';
    //     $booking->save();

    //     return response([
    //         'message' => 'Booking has been approved successfully by Baak.',
    //         'booking' => $booking
    //     ], 200);
    // }
    
    public function statusUpdate(Request $request, $id)
    {
        $rules = [
            'status' => 'required|string|in:approved,rejected',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Check if the authenticated user is a Baak
        $baak = Auth::user()->baak;

        if (!$baak) {
            return response([
                'message' => 'You do not have permission to update booking status.'
            ], 403); // HTTP status code 403 for Forbidden
        }

        // Check if the booking is associated with the Baak
        if ($booking->baak_id !== $baak->id) {
            return response([
                'message' => 'You do not have permission to update the status of this booking.'
            ], 403); // HTTP status code 403 for Forbidden
        }

        // Check if the booking is in a pending state
        if ($booking->status !== 'pending') {
            return response([
                'message' => 'Booking is not in a pending state and cannot have its status updated.'
            ], 422);
        }

        // Update the booking status
        $booking->update([
            'status' => $request->input('status'),
        ]);

        return response([
            'message' => 'Booking status successfully updated',
            'booking' => $booking
        ], 200);
    }
}
