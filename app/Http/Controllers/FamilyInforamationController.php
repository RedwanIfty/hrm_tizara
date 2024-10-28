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
            'user_id'=>'required',
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
                    'user_id' => $request->user_id,
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
    
    public function edit($id)
    {
        $familyMember = FamilyInformation::find($id);
        return response()->json($familyMember);
    }
    
    public function update(Request $request)
    {
        // Start the transaction
        DB::beginTransaction();
    
        try {
            // Validate request
            $request->validate([
                'member_id' => 'required|exists:family_members,id',
                'name' => 'required|string|max:255',
                'relationship' => 'required|string|max:255',
                'dob' => 'required|date',
                'phone' => 'required|string|max:15',
            ]);
    
            // Find the family member
            $familyMember = FamilyInformation::findOrFail($request->member_id);
    
            // Update family member details
            $familyMember->name = $request->name;
            $familyMember->relationship = $request->relationship;
            $familyMember->dob = $request->dob;
            $familyMember->phone = $request->phone;
            $familyMember->save();
    
            // Commit the transaction
            DB::commit();
            Toastr::success('Family members updated successfully!', 'Success');
    
            return response()->json(['success' => 'Family member updated successfully']);
            
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollback();
    
            return response()->json(['error' => 'An error occurred while updating the family member.'], 500);
        }
    }
}
