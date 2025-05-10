<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'document'])->get();
        return response()->json($reservations);
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $users = User::all();
        $documents = Document::all();

        return response()->json([
            'users' => $users,
            'documents' => $documents
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'document_id' => 'required|exists:documents,id',
            'reserved_at' => 'required|date',
            'status' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'document_id' => $request->document_id,
            'reserved_at' => $request->reserved_at,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Reservation created successfully', 'reservation' => $reservation], 201);
    }

    /**
     * Display the specified reservation.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['user', 'document'])->findOrFail($id);
        return response()->json($reservation);
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $users = User::all();
        $documents = Document::all();

        return response()->json([
            'reservation' => $reservation,
            'users' => $users,
            'documents' => $documents
        ]);
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'document_id' => 'sometimes|exists:documents,id',
            'reserved_at' => 'sometimes|date',
            'status' => 'sometimes|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reservation->update($request->only(['user_id', 'document_id', 'reserved_at', 'status']));

        return response()->json(['message' => 'Reservation updated successfully', 'reservation' => $reservation]);
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
