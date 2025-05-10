<?php

namespace App\Http\Controllers;

use App\Models\Citizen; // Assuming Citizen model exists
use App\Models\Role; // For managing user roles
use App\Models\Barangay; // For handling barangay assignments
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CitizenController extends Controller
{
    /**
     * Display a listing of the citizens.
     */
    public function index()
    {
        // Get all citizens with their roles and barangay information
        $citizens = Citizen::with(['role', 'barangay'])->get();
        return response()->json($citizens);
    }

    /**
     * Store a newly created citizen in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:citizens,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id', // Validate that role exists
            'barangay_id' => 'required|exists:barangays,id', // Validate that barangay exists
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Create the new citizen record
        $citizen = Citizen::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password is securely hashed
            'role_id' => $request->role_id,
            'barangay_id' => $request->barangay_id,
        ]);

        // Return success response with citizen data
        return response()->json(['message' => 'Citizen created successfully', 'citizen' => $citizen], 201);
    }

    /**
     * Display the specified citizen.
     */
    public function show($id)
    {
        // Find citizen by ID and load their role and barangay information
        $citizen = Citizen::with(['role', 'barangay'])->findOrFail($id);
        return response()->json($citizen);
    }

    /**
     * Update the specified citizen in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the citizen by ID
        $citizen = Citizen::findOrFail($id);

        // Validate incoming data (fields that are optional can be omitted in the request)
        $validated = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:citizens,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'sometimes|exists:roles,id', // Update role if provided
            'barangay_id' => 'sometimes|exists:barangays,id', // Update barangay if provided
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Update citizen fields
        $citizen->name = $request->name ?? $citizen->name;
        $citizen->email = $request->email ?? $citizen->email;
        $citizen->role_id = $request->role_id ?? $citizen->role_id;
        $citizen->barangay_id = $request->barangay_id ?? $citizen->barangay_id;

        // If password is provided, hash it and update
        if ($request->filled('password')) {
            $citizen->password = Hash::make($request->password);
        }

        // Save the updated citizen
        $citizen->save();

        // Return success response
        return response()->json(['message' => 'Citizen updated successfully', 'citizen' => $citizen]);
    }

    /**
     * Remove the specified citizen from storage.
     */
    public function destroy($id)
    {
        // Find the citizen by ID and delete them
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();

        // Return success response
        return response()->json(['message' => 'Citizen deleted successfully']);
    }
}
