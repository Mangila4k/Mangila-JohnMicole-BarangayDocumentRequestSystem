<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function approve(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // Update approval status
        $reservation->status = 'approved';
        $reservation->approved_at = now();
        $reservation->save();

        return response()->json([
            'message' => 'Reservation approved successfully',
            'reservation' => $reservation,
        ]);
    }
}
