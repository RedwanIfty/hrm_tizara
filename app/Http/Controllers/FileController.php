<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = File::with(['users' => function ($query) {
                $query->select('id', 'name'); // Only select 'id' and 'name'
            }])
                ->select('files.*') // Ensure you are selecting the correct table
                ->where('files.user_id',auth()->user()->id)
                ->where('is_deleted', 0);

            return DataTables::of($data)
                ->addColumn('name', function ($row) {
                    return $row->users->name; // Use the correct relationship
                })
                ->addColumn('actions', function ($row) {
                    return '<button class="btn btn-danger file-delete" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['actions', 'name'])
                ->make(true);
        }
        return view('cv.form'); // Your Blade view for listing
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file_type' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Store the file
//        $path = $request->file('file')->move('uploads/files');

        if ($request->hasFile('file')) {
            // Get the original file name and extension
            $originalName = $request->file('file')->getClientOriginalName();
            $extension = $request->file('file')->getClientOriginalExtension();

            // Create a unique name for the file using the original name and a timestamp
            $uniqueName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;

            // Define the path to store the file
            $destinationPath = public_path('uploads/files');

            // Move the uploaded file to the specified directory with the new unique name
            $request->file('file')->move($destinationPath, $uniqueName);
        }
        // Create a new file entry
        $fileEntry = File::create([
            'user_id' => $request->user_id,
            'file_type' => $request->file_type,
            'file_path' => $uniqueName,
        ]);

        return response()->json(['message' => 'File uploaded successfully']);
    }
    public function download($id)
    {
        // Retrieve the file record by ID
        $file = File::findOrFail($id);

        // Path to the file in the public directory
        $filePath = public_path('uploads/files/' . $file->file_path);

        // Check if file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, $file->original_name);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
    public function destroy($id)
    {
        // Find the additional information
        $file = File::find($id);

        if ($file) {
            // Soft delete the record by setting `is_delete` flag to 1
            $file->update([
                'is_deleted' => 1,
            ]);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
