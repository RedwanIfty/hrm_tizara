<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInformation;
use App\Models\File;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Employee;
use App\Models\department;
use App\Models\EducationBackground;
use App\Models\FamilyInformation;
use App\Models\InterpersonalSkill;
use App\Models\JobExperience;
use App\Models\LearningInterest;
use App\Models\User;
use App\Models\module_permission;
use App\Models\NotableProject;
use App\Models\OtherQualification;
use App\Models\ProfessionalSkill;
use App\Models\WorkResponsibility;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    // all employee card view
    public function cardAllEmployee(Request $request)
    {
        $employees = Employee::pluck('user_id')->toArray();
//        return $employees;
        $users = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                    ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
//                    ->whereNotIn('users.id',$employees)
                    ->get();
        $userList = DB::table('users')->whereNotIn('id',$employees)->get();
        $companyList  = DB::table('companies')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('form.allemployeecard',compact('users','userList','permission_lists','companyList'));
    }
    // all employee list
    public function listAllEmployee()
    {
        $users = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                    ->leftJoin('employee_information','employee_information.user_id','=','users.id')
                    ->select(
                        'users.*',
                        'employees.birth_date',
                        'employees.gender',
                        'employees.company',
                        'employee_information.name as employee_name',
                        'employee_information.date_of_birth as employee_dob',
                        'employee_information.contact_number as employee_contact',
                        'employee_information.email as employee_email',
                        'employee_information.marital_status as marital_status',
                    )
                    ->where('employee_information.is_delete',0)
//                    ->distinct('employee_information.user_id')
                    ->get();
//        return $users;
        $userList = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        $attachedFiles=File::where('is_deleted',0)->get();
        return view('form.employeelist',compact('users','userList','permission_lists','attachedFiles'));
    }

    // save data employee
    public function saveRecord(Request $request)
    {
//        $user=User::where('email',$request->email)->first();
//        return $user;
//        return $request->all();
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email',
            'birthDate'   => 'required|string|max:255',
            'gender'      => 'required|string|max:255',
            'employee_id' => 'required|string|max:255',
            'company'     => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try{

            $employees = Employee::where('email', '=',$request->email)->first();
            $user=User::where('email',$request->email)->first();
//            return $user;
            if ($employees === null)
            {

                $employee = new Employee();
                $employee->name         = $request->name;
                $employee->email        = $request->email;
                $employee->birth_date   = $request->birthDate;
                $employee->gender       = $request->gender;
                $employee->employee_id  = $request->employee_id;
                $employee->company      = $request->company;
                $employee->user_id      = $user->id;
                $employee->save();

                for($i=0;$i<count($request->id_count);$i++)
                {
                    $module_permissions = [
                        'employee_id' => $request->employee_id,
                        'module_permission' => $request->permission[$i],
                        'id_count'          => $request->id_count[$i],
                        'read'              => $request->read[$i],
                        'write'             => $request->write[$i],
                        'create'            => $request->create[$i],
                        'delete'            => $request->delete[$i],
                        'import'            => $request->import[$i],
                        'export'            => $request->export[$i],
                    ];
                    DB::table('module_permissions')->insert($module_permissions);
                }

                DB::commit();
                Toastr::success('Add new employee successfully :)','Success');
                return redirect()->route('all/employee/card');
            } else {
                DB::rollback();
                Toastr::error('Add new employee exits :)','Error');
                return redirect()->back();
            }
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add new employee fail :)','Error');
            return redirect()->back();
        }
    }
    // view edit record
    public function viewRecord($employee_id)
    {
        $permission = DB::table('employees')
            ->join('module_permissions', 'employees.employee_id', '=', 'module_permissions.employee_id')
            ->select('employees.*', 'module_permissions.*')
            ->where('employees.employee_id','=',$employee_id)
            ->get();
        $employees = DB::table('employees')->where('employee_id',$employee_id)->get();
        $companyList = DB::table('companies')->get();
        return view('form.edit.editemployee',compact('employees','permission','companyList'));
    }
    // update record employee
    public function updateRecord( Request $request)
    {
//        return $request->all();
        DB::beginTransaction();
        try{
            // update table Employee
            $updateEmployee = [
                'id'=>$request->id,
                'name'=>$request->name,
                'email'=>$request->email,
                'birth_date'=>$request->birth_date,
                'gender'=>$request->gender,
                'employee_id'=>$request->employee_id,
                'company'=>$request->company,
            ];
            // update table user
            $updateUser = [
                'user_id'=>$request->employee_id,
                'name'=>$request->name,
                'email'=>$request->email,
            ];

            // update table module_permissions
            for($i=0;$i<count($request->id_permission);$i++)
            {
                $UpdateModule_permissions = [
                    'employee_id' => $request->employee_id,
                    'module_permission' => $request->permission[$i],
                    'id'                => $request->id_permission[$i],
                    'read'              => $request->read[$i],
                    'write'             => $request->write[$i],
                    'create'            => $request->create[$i],
                    'delete'            => $request->delete[$i],
                    'import'            => $request->import[$i],
                    'export'            => $request->export[$i],
                ];
                module_permission::where('id',$request->id_permission[$i])->update($UpdateModule_permissions);
            }

            User::where('user_id',$request->employee_id)->update($updateUser);
            Employee::where('id',$request->id)->update($updateEmployee);

            DB::commit();
            Toastr::success('updated record successfully :)','Success');
            return redirect()->route('all/employee/card');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('updated record fail :)','Error');
            return redirect()->back();
        }
    }
    // delete record
    public function deleteRecord($employee_id)
    {
        DB::beginTransaction();
        try{

            Employee::where('employee_id',$employee_id)->delete();
            module_permission::where('employee_id',$employee_id)->delete();

            DB::commit();
            Toastr::success('Delete record successfully :)','Success');
            return redirect()->route('all/employee/card');

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete record fail :)','Error');
            return redirect()->back();
        }
    }
    // employee search
    public function employeeSearch(Request $request)
    {
        $users = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                    ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                    ->get();
        $permission_lists = DB::table('permission_lists')->get();
        $userList = DB::table('users')->get();
        $companyList   = DB::table('companies')->get();

        // search by id
        if($request->employee_id)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->get();
        }
        // search by name
        if($request->name)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->get();
        }
        // search by name
        if($request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }

        // search by name and id
        if($request->employee_id && $request->name)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->get();
        }
        // search by position and id
        if($request->employee_id && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }
        // search by name and position
        if($request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }
         // search by name and position and id
         if($request->employee_id && $request->name && $request->position)
         {
             $users = DB::table('users')
                         ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                         ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                         ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                         ->where('users.name','LIKE','%'.$request->name.'%')
                         ->where('users.position','LIKE','%'.$request->position.'%')
                         ->get();
         }
        return view('form.allemployeecard',compact('users','userList','permission_lists','companyList'));
    }
    public function employeeListSearch(Request $request)
    {
        $users = DB::table('users')
                    ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                    ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                    ->get();
        $permission_lists = DB::table('permission_lists')->get();
        $userList = DB::table('users')->get();

        // search by id
        if($request->employee_id)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->get();
        }
        // search by name
        if($request->name)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->get();
        }
        // search by name
        if($request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }

        // search by name and id
        if($request->employee_id && $request->name)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->get();
        }
        // search by position and id
        if($request->employee_id && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }
        // search by name and position
        if($request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }
        // search by name and position and id
        if($request->employee_id && $request->name && $request->position)
        {
            $users = DB::table('users')
                        ->join('employees', 'users.user_id', '=', 'employees.employee_id')
                        ->select('users.*', 'employees.birth_date', 'employees.gender', 'employees.company')
                        ->where('employee_id','LIKE','%'.$request->employee_id.'%')
                        ->where('users.name','LIKE','%'.$request->name.'%')
                        ->where('users.position','LIKE','%'.$request->position.'%')
                        ->get();
        }
        $attachedFiles=File::where('is_deleted',0)->get();

        return view('form.employeelist',compact('users','userList','permission_lists','attachedFiles'));
    }

    // employee profile with all controller user
    public function profileEmployee($user_id)
    {
        $users = DB::table('users')
                ->leftJoin('personal_information','personal_information.user_id','users.user_id')
                ->leftJoin('profile_information','profile_information.user_id','users.user_id')
                ->leftJoin('employee_information','employee_information.user_id','users.id')
                ->where('users.user_id',$user_id)
                ->first();

    //    return $user_id;
        $user = DB::table('users')
                ->leftJoin('personal_information','personal_information.user_id','users.user_id')
                ->leftJoin('profile_information','profile_information.user_id','users.user_id')
                ->leftJoin('employee_information','employee_information.user_id','users.id')
                ->where('users.user_id',$user_id)
                ->get();
        $userId=User::where('user_id',$user_id)->first('id');
        // return $userId;
        $familyInformations = FamilyInformation::where('user_id', $userId->id)->get(); // Fixed the typo
        // return $familyInformations;
        $employee=User::where('user_id',$user_id)->first();
        return view('form.employeeprofile',compact('user','users','familyInformations','employee'));
    }

    /** page departments */
    public function index()
    {
        $departments = DB::table('departments')->get();
        return view('form.departments',compact('departments'));
    }

    /** save record department */
    public function saveRecordDepartment(Request $request)
    {
        $request->validate([
            'department'        => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try{

            $department = department::where('department',$request->department)->first();
            if ($department === null)
            {
                $department = new department;
                $department->department = $request->department;
                $department->save();

                DB::commit();
                Toastr::success('Add new department successfully :)','Success');
                return redirect()->route('form/departments/page');
            } else {
                DB::rollback();
                Toastr::error('Add new department exits :)','Error');
                return redirect()->back();
            }
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add new department fail :)','Error');
            return redirect()->back();
        }
    }

    /** update record department */
    public function updateRecordDepartment(Request $request)
    {
        DB::beginTransaction();
        try{
            // update table departments
            $department = [
                'id'=>$request->id,
                'department'=>$request->department,
            ];
            department::where('id',$request->id)->update($department);

            DB::commit();
            Toastr::success('updated record successfully :)','Success');
            return redirect()->route('form/departments/page');
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)','Error');
            return redirect()->back();
        }
    }

    /** delete record department */
    public function deleteRecordDepartment(Request $request)
    {
        try {

            department::destroy($request->id);
            Toastr::success('Department deleted successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Department delete fail :)','Error');
            return redirect()->back();
        }
    }

    /** page designations */
    public function designationsIndex()
    {
        return view('form.designations');
    }

    /** page time sheet */
    public function timeSheetIndex()
    {
        return view('form.timesheet');
    }

    /** page overtime */
    public function overTimeIndex()
    {
        return view('form.overtime');
    }
    public function cvInformationIndex($id)
    {
        if (auth()->user()->role_name != "Super Admin" && auth()->user()->role_name != "Admin") {
            return abort(403);
        }

        // Eager load related data
        $employeeInformation = DB::table('users')
            ->leftJoin('employee_information', 'employee_information.user_id', '=', 'users.id')
            ->where('employee_information.user_id', $id)
            ->where('employee_information.is_delete', 0)
            ->select('users.*', 'employee_information.*')
            ->first();

        // Format date only if date_of_birth is not null
        if (!empty($employeeInformation->date_of_birth)) {
            $employeeInformation->date_of_birth = Carbon::parse($employeeInformation->date_of_birth)->format('jS F Y');
        }

        // Eager load educational background and format graduation year
        $educationalBackground = EducationBackground::where('user_id', $id)->where('is_delete',0)->first();
        if ($educationalBackground && !empty($educationalBackground->graduation_year)) {
            $educationalBackground->graduation_year = Carbon::parse($educationalBackground->graduation_year)->format('jS F Y');
        }

        // Fetch other related data in a single query
        $otherQualifications = OtherQualification::where('user_id', $id)->where('is_delete',0)->get();
        foreach ($otherQualifications as $qualification) {
            if (!empty($qualification->passing_year)) {
                $qualification->passing_year = Carbon::parse($qualification->passing_year)->format('jS F Y');
            }
        }
        $workResposibility = WorkResponsibility::where('user_id', $id)->where('is_delete',0)->first();
        $jobExperiences = JobExperience::where('user_id', $id)->where('is_delete',0)->get();
        foreach($jobExperiences as $jobExperience){
            $jobExperience->date = Carbon::parse($jobExperience->date)->format('jS F Y');
        }
        $professionalSkills=ProfessionalSkill::where('user_id',$id)->where('is_delete',0)->get();
        $interpersonalSkills=InterpersonalSkill::where('user_id',$id)->where('is_delete',0)->get();
        $notableProjects=NotableProject::where('user_id',$id)->where('is_delete',0)->get();
        $learningInterests=LearningInterest::where('user_id',$id)->where('is_delete',0)->get();
        $additionalInformations=AdditionalInformation::where('user_id',$id)->where('is_delete',0)->get();
        $attachFiles=File::where('user_id',$id)->where('is_deleted',0)->get();
//        return $attachFiles;
        // Return the view with compacted variables
        return view('form.cvinformation', compact(
            'employeeInformation',
            'educationalBackground',
            'otherQualifications',
            'workResposibility',
            'jobExperiences',
            'professionalSkills',
            'interpersonalSkills',
            'notableProjects',
            'learningInterests',
            'additionalInformations',
            'attachFiles'
        ));
    }
    public function dummyData(){
        return view('dummy-data');
    }

}
