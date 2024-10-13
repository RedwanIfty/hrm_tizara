<?php

namespace App\Http\Controllers;

use App\Models\EducationBackground;
use App\Models\EmployeeInformation;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

class CVController extends Controller
{
    public function form(){
        $users=User::where('id',auth()->id())->get();
        $employeeInformation=EmployeeInformation::where('user_id',auth()->user()->id)->where('is_delete',0)->first();
        $employeeEducation=EducationBackground::where('user_id',auth()->user()->id)->where('is_delete',0)->first();
        $fileTypes=File::where('is_deleted',0)->get();
        return view('cv.form',compact('users','employeeInformation','employeeEducation','fileTypes'));
    }
}
