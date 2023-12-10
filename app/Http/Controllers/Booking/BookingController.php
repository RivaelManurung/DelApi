<?php

namespace App\Http\Controllers\Booking;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil semua booking
        $bookings = Booking::with('user', 'ruangan')->get();

        return response([
            'bookings' => $bookings
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
    
}
