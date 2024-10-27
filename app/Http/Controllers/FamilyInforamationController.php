<?php

namespace App\Http\Controllers;

use App\Models\FamilyInformation;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;

class FamilyInforamationController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name.*' => 'required|string|max:255',
            'relationship.*' => 'required|string|max:255',
            'dob.*' => 'required|date',
            'phone.*' => 'required|string|max:15',
        ]);
    
        try {
            DB::beginTransaction(); // Start the transaction
    
            $familyMembers = [];
            
            // Loop through each family member entry
            foreach ($request->name as $index => $name) {
                $familyMembers[] = FamilyInformation::create([
                    'user_id' => auth()->id(),
                    'name' => $name,
                    'relationship' => $request->relationship[$index],
                    'dob' => $request->dob[$index],
                    'phone' => $request->phone[$index],
                ]);
            }
    
            DB::commit(); // Commit the transaction
    
            Toastr::success('Family members added successfully!', 'Success');
    
            // Return a JSON response with the newly created family members
            return response()->json([
                'success' => 'Family members added successfully!',
                'data' => $familyMembers
            ]);
    
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of error
    
            // Log the error for debugging purposes
            \Log::error('Error adding family members: ' . $e->getMessage());
    
            return response()->json([
                'error' => 'Something went wrong while adding family members. Please try again.'
            ], 500);
        }
    }
    

}
