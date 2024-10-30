<?php

namespace App\Http\Controllers;

use App\Models\BankInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class BankInformationController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:20',
            'pan_number' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            BankInformation::updateOrCreate(
                ['user_id' => Auth::id()],
                $data
            );

            DB::commit();
            Toastr::success('Bank information saved successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Failed to save bank information. Please try again.', 'Error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $bankInfo = BankInformation::where('user_id', Auth::id())->where('id', $id)->first();

            if ($bankInfo) {
                $bankInfo->delete();
                DB::commit();
                Toastr::success('Bank information deleted successfully :)', 'Success');
                return redirect()->back();
            }

            Toastr::error('Bank information not found.', 'Error');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Failed to delete bank information. Please try again.', 'Error');
            return redirect()->back();
        }
    }
}
