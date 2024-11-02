<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ApplicationController extends Controller
{
    public function leaves()
    {
        $leaves = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->select('leaves_admins.*', 'users.position','users.name','users.avatar')
            ->get();

        return view('form.leaves',compact('leaves'));
    }
    public function applicationForm(){
        $leaveType=LeaveType::whereIn('l_type_id',[1,2,5,6,7,8,10,12,17])->get();
//        return $leaveType;
        $admin=User::where('role_id',1)->get();
        return view('form.application',compact('leaveType','admin'));
    }
}
