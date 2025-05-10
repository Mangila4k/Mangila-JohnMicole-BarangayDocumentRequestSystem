<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $documents = Document::all();
        return response()->json($documents);
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        // If you're using web forms
        return view('documents.create');
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $document = Document::create([
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Document created successfully', 'document' => $document], 201);
    }

    /**
     * Display the specified document.
     */
    public function show(string $id)
    {
        $document = Document::findOrFail($id);
        return response()->json($document);
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $document->update($request->only(['type', 'description']));

        return response()->json(['message' => 'Document updated successfully', 'document' => $document]);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
