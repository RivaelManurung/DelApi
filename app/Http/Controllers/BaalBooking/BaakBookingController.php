<?php

namespace App\Http\Controllers\BaakBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;


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
}
