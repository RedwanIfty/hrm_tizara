<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register()
    {
        $role = DB::table('role_type_users')->whereNotIn('id',[1,2,4])->get();
        return view('auth.register',compact('role'));
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'role_name' => 'required|string|max:255',
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $dt       = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
//        return $request->all();
        $role=DB::table('role_type_users')->where('role_type',$request->role_name)->first();
        $user=User::create([
            'name'      => $request->name,
            'role_id'   => $role->id,
            'avatar'    => $request->image,
            'email'     => $request->email,
            'join_date' => $todayDate,
            'role_name' => $request->role_name,
            'status'    => 'Active',
            'password'  => Hash::make($request->password),
        ]);
        $user->update([
            'user_id' => 'tz-000' . $user->id,
        ]);

        Toastr::success('Create new account successfully :)','Success');
        return redirect('login');
    }
}
