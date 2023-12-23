<?php

namespace App\Http\Controllers\BaakBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;




class BaakBookingController extends Controller
{
    public function getAllBookings()
    {
        try {
            $bookings = Booking::all(); // You can modify this based on your requirements
            return response()->json(['bookings' => $bookings], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

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
