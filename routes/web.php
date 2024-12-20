<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\EducationBackgroundController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeInformationController;
use App\Http\Controllers\LockScreen;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\ExpenseReportsController;
use App\Http\Controllers\JobExperienceController;
use App\Http\Controllers\OtherQualificationController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\WorkResponsibilityController;
use App\View\Components\JobExperience\JobExperience;
use App\Http\Controllers\ProfessionalSkillController;
use App\Http\Controllers\InterpersonalSkillController;
use App\Http\Controllers\NotableProjectController;
use App\Http\Controllers\LearningInterestController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\BankInformationController;
use App\Http\Controllers\FamilyInforamationController;
use App\Http\Controllers\FileController;
use App\Models\FamilyInformation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('home');
    });
    Route::get('home', function () {
        return view('home');
    });
});

Auth::routes();

// ----------------------------- main dashboard ------------------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('em/dashboard', 'emDashboard')->name('em/dashboard');
});

// -----------------------------settings----------------------------------------//
Route::controller(SettingController::class)->group(function () {
    Route::get('company/settings/page', 'companySettings')->middleware('auth')->name('company/settings/page');
    Route::get('roles/permissions/page', 'rolesPermissions')->middleware('auth')->name('roles/permissions/page');
    Route::post('roles/permissions/save', 'addRecord')->middleware('auth')->name('roles/permissions/save');
    Route::post('roles/permissions/update', 'editRolesPermissions')->middleware('auth')->name('roles/permissions/update');
    Route::post('roles/permissions/delete', 'deleteRolesPermissions')->middleware('auth')->name('roles/permissions/delete');
});

// -----------------------------login----------------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// ----------------------------- lock screen --------------------------------//
Route::controller(LockScreen::class)->group(function () {
    Route::get('lock_screen', 'lockScreen')->middleware('auth')->name('lock_screen');
    Route::post('unlock', 'unlock')->name('unlock');
});

// ------------------------------ register ---------------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'storeUser')->name('register');
});

// ----------------------------- forget password ----------------------------//
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('forget-password', 'getEmail')->name('forget-password');
    Route::post('forget-password', 'postEmail')->name('forget-password');
});

// ----------------------------- reset password -----------------------------//
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'getPassword');
    Route::post('reset-password', 'updatePassword');
});

// ----------------------------- user profile ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('profile_user', 'profile')->middleware('auth')->name('profile_user');
    Route::post('profile/information/save', 'profileInformation')->name('profile/information/save');
    Route::put('/user/update-website-link',  'updateWebsiteLink')->middleware('auth')->name('user.updateWebsiteLink');
    Route::get('/user/list','list')->middleware('auth')->name('user.list');
    Route::get('/user/edit-website-link/{id}', 'editWebsiteLink')->middleware('auth')->name('user.editWebsiteLink');
    Route::delete('/user/delete-website-link/{id}',  'deleteWebsiteLink')->middleware('auth')->name('user.deleteWebsiteLink');

});

// ----------------------------- user userManagement -----------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('userManagement', 'index')->middleware('auth')->name('userManagement');
    Route::post('user/add/save', 'addNewUserSave')->name('user/add/save');
    Route::post('search/user/list', 'searchUser')->name('search/user/list');
    Route::post('update', 'update')->name('update');
    Route::post('user/delete', 'delete')->middleware('auth')->name('user/delete');
    Route::get('activity/log', 'activityLog')->middleware('auth')->name('activity/log');
    Route::get('activity/login/logout', 'activityLogInLogOut')->middleware('auth')->name('activity/login/logout');
});

// ----------------------------- search user management ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::post('search/user/list', 'searchUser')->name('search/user/list');
});

// ----------------------------- form change password ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('change/password', 'changePasswordView')->middleware('auth')->name('change/password');
    Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');
});

// ----------------------------- job ------------------------------//
Route::controller(JobController::class)->group(function () {
    Route::get('form/job/list', 'jobList')->name('form/job/list');
    Route::get('form/job/view/{id}', 'jobView');
    Route::get('user/dashboard/index', 'userDashboard')->middleware('auth')->name('user/dashboard/index');
    Route::get('jobs/dashboard/index', 'jobsDashboard')->middleware('auth')->name('jobs/dashboard/index');
    Route::get('user/dashboard/all', 'userDashboardAll')->middleware('auth')->name('user/dashboard/all');
    Route::get('user/dashboard/save', 'userDashboardSave')->middleware('auth')->name('user/dashboard/save');
    Route::get('user/dashboard/applied/jobs', 'userDashboardApplied')->middleware('auth')->name('user/dashboard/applied/jobs');
    Route::get('user/dashboard/interviewing', 'userDashboardInterviewing')->middleware('auth')->name('user/dashboard/interviewing');
    Route::get('user/dashboard/offered/jobs', 'userDashboardOffered')->middleware('auth')->name('user/dashboard/offered/jobs');
    Route::get('user/dashboard/visited/jobs', 'userDashboardVisited')->middleware('auth')->name('user/dashboard/visited/jobs');
    Route::get('user/dashboard/archived/jobs', 'userDashboardArchived')->middleware('auth')->name('user/dashboard/archived/jobs');
    Route::get('jobs', 'Jobs')->middleware('auth')->name('jobs');
    Route::get('job/applicants/{job_title}', 'jobApplicants')->middleware('auth');
    Route::get('job/details/{id}', 'jobDetails')->middleware('auth');
    Route::get('cv/download/{id}', 'downloadCV')->middleware('auth');

    Route::post('form/jobs/save', 'JobsSaveRecord')->name('form/jobs/save');
    Route::post('form/apply/job/save', 'applyJobSaveRecord')->name('form/apply/job/save');
    Route::post('form/apply/job/update', 'applyJobUpdateRecord')->name('form/apply/job/update');

    Route::get('page/manage/resumes', 'manageResumesIndex')->middleware('auth')->name('page/manage/resumes');
    Route::get('page/shortlist/candidates', 'shortlistCandidatesIndex')->middleware('auth')->name('page/shortlist/candidates');
    Route::get('page/interview/questions', 'interviewQuestionsIndex')->middleware('auth')->name('page/interview/questions'); // view page
    Route::post('save/category', 'categorySave')->name('save/category'); // save record category
    Route::post('save/questions', 'questionSave')->name('save/questions'); // save record questions
    Route::post('questions/update', 'questionsUpdate')->name('questions/update'); // update question
    Route::post('questions/delete', 'questionsDelete')->middleware('auth')->name('questions/delete'); // delete question
    Route::get('page/offer/approvals', 'offerApprovalsIndex')->middleware('auth')->name('page/offer/approvals');
    Route::get('page/experience/level', 'experienceLevelIndex')->middleware('auth')->name('page/experience/level');
    Route::get('page/candidates', 'candidatesIndex')->middleware('auth')->name('page/candidates');
    Route::get('page/schedule/timing', 'scheduleTimingIndex')->middleware('auth')->name('page/schedule/timing');
    Route::get('page/aptitude/result', 'aptituderesultIndex')->middleware('auth')->name('page/aptitude/result');

});

// ----------------------------- form employee ------------------------------//
Route::controller(EmployeeController::class)->group(function () {
    Route::get('all/employee/card', 'cardAllEmployee')->middleware('auth')->name('all/employee/card');
    Route::get('all/employee/list', 'listAllEmployee')->middleware('auth')->name('all/employee/list');
    Route::post('all/employee/save', 'saveRecord')->middleware('auth')->name('all/employee/save');
    Route::get('all/employee/view/edit/{employee_id}', 'viewRecord');
    Route::post('all/employee/update', 'updateRecord')->middleware('auth')->name('all/employee/update');
    Route::get('all/employee/delete/{employee_id}', 'deleteRecord')->middleware('auth');
    Route::post('all/employee/search', 'employeeSearch')->name('all/employee/search');
    Route::post('all/employee/list/search', 'employeeListSearch')->name('all/employee/list/search');

    Route::get('form/departments/page', 'index')->middleware('auth')->name('form/departments/page');
    Route::post('form/departments/save', 'saveRecordDepartment')->middleware('auth')->name('form/departments/save');
    Route::post('form/department/update', 'updateRecordDepartment')->middleware('auth')->name('form/department/update');
    Route::post('form/department/delete', 'deleteRecordDepartment')->middleware('auth')->name('form/department/delete');

    Route::get('form/designations/page', 'designationsIndex')->middleware('auth')->name('form/designations/page');
    Route::post('form/designations/save', 'saveRecordDesignations')->middleware('auth')->name('form/designations/save');
    Route::post('form/designations/update', 'updateRecordDesignations')->middleware('auth')->name('form/designations/update');
    Route::post('form/designations/delete', 'deleteRecordDesignations')->middleware('auth')->name('form/designations/delete');

    Route::get('form/timesheet/page', 'timeSheetIndex')->middleware('auth')->name('form/timesheet/page');
    Route::post('form/timesheet/save', 'saveRecordTimeSheets')->middleware('auth')->name('form/timesheet/save');
    Route::post('form/timesheet/update', 'updateRecordTimeSheets')->middleware('auth')->name('form/timesheet/update');
    Route::post('form/timesheet/delete', 'deleteRecordTimeSheets')->middleware('auth')->name('form/timesheet/delete');

    Route::get('form/overtime/page', 'overTimeIndex')->middleware('auth')->name('form/overtime/page');
    Route::post('form/overtime/save', 'saveRecordOverTime')->middleware('auth')->name('form/overtime/save');
    Route::post('form/overtime/update', 'updateRecordOverTime')->middleware('auth')->name('form/overtime/update');
    Route::post('form/overtime/delete', 'deleteRecordOverTime')->middleware('auth')->name('form/overtime/delete');

    Route::get('employee/cv-information/{id}','cvInformationIndex')->middleware('auth')->name('employee.cv');
    Route::get('employee/dummy-data','dummyData')->middleware('auth')->name('dummy.data');
});

// ----------------------------- profile employee ------------------------------//
Route::controller(EmployeeController::class)->group(function () {
    Route::get('employee/profile/{user_id}', 'profileEmployee')->middleware('auth');
});

// ----------------------------- form holiday ------------------------------//
Route::controller(HolidayController::class)->group(function () {
    Route::get('form/holidays/new', 'holiday')->middleware('auth')->name('form/holidays/new');
    Route::post('form/holidays/save', 'saveRecord')->middleware('auth')->name('form/holidays/save');
    Route::post('form/holidays/update', 'updateRecord')->middleware('auth')->name('form/holidays/update');
});

// ----------------------------- form leaves ------------------------------//
Route::controller(LeavesController::class)->group(function () {
    Route::get('form/leaves/new', 'leaves')->middleware('auth')->name('form/leaves/new');
    Route::get('form/leavesemployee/new', 'leavesEmployee')->middleware('auth')->name('form/leavesemployee/new');
    Route::post('form/leaves/save', 'saveRecord')->middleware('auth')->name('form/leaves/save');
    Route::post('form/leaves/edit', 'editRecordLeave')->middleware('auth')->name('form/leaves/edit');
    Route::post('form/leaves/edit/delete', 'deleteLeave')->middleware('auth')->name('form/leaves/edit/delete');
});

// ----------------------------- form attendance  ------------------------------//
Route::controller(LeavesController::class)->group(function () {
    Route::get('form/leavesettings/page', 'leaveSettings')->middleware('auth')->name('form/leavesettings/page');
    Route::get('attendance/page', 'attendanceIndex')->middleware('auth')->name('attendance/page');
    Route::get('attendance/employee/page', 'AttendanceEmployee')->middleware('auth')->name('attendance/employee/page');
    Route::get('form/shiftscheduling/page', 'shiftScheduLing')->middleware('auth')->name('form/shiftscheduling/page');
    Route::get('form/shiftlist/page', 'shiftList')->middleware('auth')->name('form/shiftlist/page');
});

// ----------------------------- form payroll  ------------------------------//
Route::controller(PayrollController::class)->group(function () {
    Route::get('form/salary/page', 'salary')->middleware('auth')->name('form/salary/page');
    Route::post('form/salary/save', 'saveRecord')->middleware('auth')->name('form/salary/save');
    Route::post('form/salary/update', 'updateRecord')->middleware('auth')->name('form/salary/update');
    Route::post('form/salary/delete', 'deleteRecord')->middleware('auth')->name('form/salary/delete');
    Route::get('form/salary/view/{user_id}', 'salaryView')->middleware('auth');
    Route::get('form/payroll/items', 'payrollItems')->middleware('auth')->name('form/payroll/items');
});

// ----------------------------- reports  ------------------------------//
Route::controller(ExpenseReportsController::class)->group(function () {
    Route::get('form/expense/reports/page', 'index')->middleware('auth')->name('form/expense/reports/page');
    Route::get('form/invoice/reports/page', 'invoiceReports')->middleware('auth')->name('form/invoice/reports/page');
    Route::get('form/daily/reports/page', 'dailyReport')->middleware('auth')->name('form/daily/reports/page');
    Route::get('form/leave/reports/page', 'leaveReport')->middleware('auth')->name('form/leave/reports/page');
});

// ----------------------------- performance  ------------------------------//
Route::controller(PerformanceController::class)->group(function () {
    Route::get('form/performance/indicator/page', 'index')->middleware('auth')->name('form/performance/indicator/page');
    Route::get('form/performance/page', 'performance')->middleware('auth')->name('form/performance/page');
    Route::get('form/performance/appraisal/page', 'performanceAppraisal')->middleware('auth')->name('form/performance/appraisal/page');
    Route::post('form/performance/indicator/save', 'saveRecordIndicator')->middleware('auth')->name('form/performance/indicator/save');
    Route::post('form/performance/indicator/delete', 'deleteIndicator')->middleware('auth')->name('form/performance/indicator/delete');
    Route::post('form/performance/indicator/update', 'updateIndicator')->middleware('auth')->name('form/performance/indicator/update');
    Route::post('form/performance/appraisal/save', 'saveRecordAppraisal')->middleware('auth')->name('form/performance/appraisal/save');
    Route::post('form/performance/appraisal/update', 'updateAppraisal')->middleware('auth')->name('form/performance/appraisal/update');
    Route::post('form/performance/appraisal/delete', 'deleteAppraisal')->middleware('auth')->name('form/performance/appraisal/delete');
});

// ----------------------------- training  ------------------------------//
Route::controller(TrainingController::class)->group(function () {
    Route::get('form/training/list/page', 'index')->middleware('auth')->name('form/training/list/page');
    Route::post('form/training/save', 'addNewTraining')->middleware('auth')->name('form/training/save');
    Route::post('form/training/delete', 'deleteTraining')->middleware('auth')->name('form/training/delete');
    Route::post('form/training/update', 'updateTraining')->middleware('auth')->name('form/training/update');
});

// ----------------------------- trainers  ------------------------------//
Route::controller(TrainersController::class)->group(function () {
    Route::get('form/trainers/list/page', 'index')->middleware('auth')->name('form/trainers/list/page');
    Route::post('form/trainers/save', 'saveRecord')->middleware('auth')->name('form/trainers/save');
    Route::post('form/trainers/update', 'updateRecord')->middleware('auth')->name('form/trainers/update');
    Route::post('form/trainers/delete', 'deleteRecord')->middleware('auth')->name('form/trainers/delete');
});

// ----------------------------- training type  ------------------------------//
Route::controller(TrainingTypeController::class)->group(function () {
    Route::get('form/training/type/list/page', 'index')->middleware('auth')->name('form/training/type/list/page');
    Route::post('form/training/type/save', 'saveRecord')->middleware('auth')->name('form/training/type/save');
    Route::post('form//training/type/update', 'updateRecord')->middleware('auth')->name('form//training/type/update');
    Route::post('form//training/type/delete', 'deleteTrainingType')->middleware('auth')->name('form//training/type/delete');
});

// ----------------------------- sales  ------------------------------//
Route::controller(SalesController::class)->group(function () {

    // -------------------- estimate  -------------------//
    Route::get('form/estimates/page', 'estimatesIndex')->middleware('auth')->name('form/estimates/page');
    Route::get('create/estimate/page', 'createEstimateIndex')->middleware('auth')->name('create/estimate/page');
    Route::get('edit/estimate/{estimate_number}', 'editEstimateIndex')->middleware('auth');
    Route::get('estimate/view/{estimate_number}', 'viewEstimateIndex')->middleware('auth');

    Route::post('create/estimate/save', 'createEstimateSaveRecord')->middleware('auth')->name('create/estimate/save');
    Route::post('create/estimate/update', 'EstimateUpdateRecord')->middleware('auth')->name('create/estimate/update');
    Route::post('estimate_add/delete', 'EstimateAddDeleteRecord')->middleware('auth')->name('estimate_add/delete');
    Route::post('estimate/delete', 'EstimateDeleteRecord')->middleware('auth')->name('estimate/delete');
    // ---------------------- payments  ---------------//
    Route::get('payments', 'Payments')->middleware('auth')->name('payments');
    Route::get('expenses/page', 'Expenses')->middleware('auth')->name('expenses/page');
    Route::post('expenses/save', 'saveRecord')->middleware('auth')->name('expenses/save');
    Route::post('expenses/update', 'updateRecord')->middleware('auth')->name('expenses/update');
    Route::post('expenses/delete', 'deleteRecord')->middleware('auth')->name('expenses/delete');
    // ---------------------- search expenses  ---------------//
    Route::get('expenses/search', 'searchRecord')->middleware('auth')->name('expenses/search');
    Route::post('expenses/search', 'searchRecord')->middleware('auth')->name('expenses/search');

});

// ----------------------------- training type  ------------------------------//
Route::controller(PersonalInformationController::class)->group(function () {
    Route::post('user/information/save', 'saveRecord')->middleware('auth')->name('user/information/save');
});

Route::controller(CVController::class)->group(function () {
    Route::get('cv/form', 'form')->middleware('auth')->name('cv.form');
});
//Employee personal Information Controller
Route::controller(EmployeeInformationController::class)->group(function () {
    Route::post('employee/information', 'store')->middleware('auth')->name('employee_information.store');
    Route::get('employee/personal-information', 'index')->middleware('auth')->name('personal.information');
    Route::get('employee_information/{id}/edit', 'edit')->middleware('auth')->name('employee_information.edit');
    Route::delete('employee_information/{id}', 'destroy')->middleware('auth')->name('employee_information.delete');

    Route::post('employee/personal-information/{id}/update', 'update')->middleware('auth')->name('employee_information.update');
});
//Education background controller
Route::controller(EducationBackgroundController::class)->group(function () {
    Route::post('employee/education-background', 'store')->middleware('auth')->name('education_background.store');
    Route::get('education-background', 'index')->middleware('auth')->name('education-background.index'); // List
    Route::get('education-background/create', 'create')->middleware('auth')->name('education-background.create'); // Create view
    Route::get('education-background/{id}/edit', 'edit')->middleware('auth')->name('education-background.edit'); // Edit view
    Route::put('education-background/{id}', 'update')->middleware('auth')->name('education-background.update'); // Update record
    Route::delete('education-background/{id}', 'destroy')->middleware('auth')->name('education-background.destroy'); // Delete record

});
Route::controller(OtherQualificationController::class)->group(function () {
    Route::post('/other-qualifications/store', 'store')->middleware('auth')->name('other_qualifications.store');
    Route::get('other-qualifications', 'index')->middleware('auth')->name('other-qualifications.index'); // List
    Route::get('other-qualifications/{id}/edit', 'edit')->middleware('auth')->name('other-qualifications.edit');
    Route::put('other-qualifications/{id}', 'update')->middleware('auth')->name('other-qualifications.update'); // Update record
    Route::delete('other-qualifications/{id}', 'destroy')->middleware('auth')->name('other-qualifications.destroy'); // Delete record

});
Route::controller(WorkResponsibilityController::class)->group(function () {
    Route::post('/work-responsibilities/store', 'store')->middleware('auth')->name('work-responsibilities.store');
    Route::get('/work-responsibilities', 'index')->middleware('auth')->name('work-responsibilities.index');
    Route::get('/work-responsibilities/{id}/edit', 'edit')->middleware('auth')->name('work-responsibilities.edit');
    Route::put('/work-responsibilities/{id}', 'update')->middleware('auth')->name('work-responsibilities.update'); // Update record
    Route::delete('/work-responsibilities/{id}', 'destroy')->middleware('auth')->name('work-responsibilities.delete');

});

Route::controller(JobExperienceController::class)->group(function () {
    Route::post('/job-experience/store', 'store')->middleware('auth')->name('job-experience.store');
    Route::get('/job-experience', 'index')->middleware('auth')->name('job-experience.index');
    Route::get('/job-experience/{id}/edit', 'edit')->middleware('auth')->name('job-experience.edit');
    Route::put('/job-experience/{id}', 'update')->middleware('auth')->name('job-experience.update'); // Update record
    Route::delete('/job-experience/{id}', 'destroy')->middleware('auth')->name('job-experience.delete');

});
Route::controller(ProfessionalSkillController::class)->group(function () {
    Route::post('/professional-skill/store', 'store')->middleware('auth')->name('professional-skill.store');
    Route::get('/professional-skill', 'index')->middleware('auth')->name('professional-skill.index');
    Route::get('/professional-skill/{id}/edit', 'edit')->middleware('auth')->name('professional-skill.edit');
    Route::put('/professional-skill/{id}', 'update')->middleware('auth')->name('professional-skill.update'); // Update record
    Route::delete('/professional-skill/{id}', 'destroy')->middleware('auth')->name('professional-skill.delete');

});

Route::controller(InterpersonalSkillController::class)->group(function () {
    Route::post('/interpersonal-skill/store', 'store')->middleware('auth')->name('interpersonal-skill.store');
    Route::get('/interpersonal-skill', 'index')->middleware('auth')->name('interpersonal-skill.index');
    Route::get('/interpersonal-skill/{id}/edit', 'edit')->middleware('auth')->name('interpersonal-skill.edit');
    Route::put('/interpersonal-skill/{id}', 'update')->middleware('auth')->name('interpersonal-skill.update'); // Update record
    Route::delete('/interpersonal-skill/{id}', 'destroy')->middleware('auth')->name('interpersonal-skill.delete');
});
Route::controller(NotableProjectController::class)->group(function () {
    Route::post('/notable-project/store', 'store')->middleware('auth')->name('notable-project.store'); // Store new project
    Route::get('/notable-project', 'index')->middleware('auth')->name('notable-project.index'); // List all projects
    Route::get('/notable-project/{id}/edit', 'edit')->middleware('auth')->name('notable-project.edit'); // Edit project
    Route::put('/notable-project/{id}', 'update')->middleware('auth')->name('notable-project.update'); // Update project
    Route::delete('/notable-project/{id}', 'destroy')->middleware('auth')->name('notable-project.delete'); // Delete project
});
Route::controller(LearningInterestController::class)->group(function () {
    Route::post('/learning-interest/store', 'store')->middleware('auth')->name('learning-interest.store'); // Store new learning interest
    Route::get('/learning-interest', 'index')->middleware('auth')->name('learning-interest.index'); // List all learning interests
    Route::get('/learning-interest/{id}/edit', 'edit')->middleware('auth')->name('learning-interest.edit'); // Edit learning interest
    Route::put('/learning-interest/{id}', 'update')->middleware('auth')->name('learning-interest.update'); // Update learning interest
    Route::delete('/learning-interest/{id}', 'destroy')->middleware('auth')->name('learning-interest.delete'); // Delete learning interest
});
Route::controller(AdditionalInformationController::class)->group(function () {
    Route::post('/additional-information/store', 'store')->middleware('auth')->name('additional-information.store'); // Store new additional information
    Route::get('/additional-information', 'index')->middleware('auth')->name('additional-information.index'); // List all additional information
    Route::get('/additional-information/{id}/edit', 'edit')->middleware('auth')->name('additional-information.edit'); // Edit additional information
    Route::put('/additional-information/{id}', 'update')->middleware('auth')->name('additional-information.update'); // Update additional information
    Route::delete('/additional-information/{id}', 'destroy')->middleware('auth')->name('additional-information.delete'); // Delete additional information
});
Route::controller(FileController::class)->group(function () {
    Route::post('/file/store', 'store')->middleware('auth')->name('files.store'); // Store new additional information
    Route::get('/file', 'index')->middleware('auth')->name('files.index'); // List all additional information
    Route::get('/file/{id}/edit', 'edit')->middleware('auth')->name('files.edit'); // Edit additional information
    Route::put('/file/{id}', 'update')->middleware('auth')->name('files.update'); // Update additional information
    Route::delete('/file/{id}', 'destroy')->middleware('auth')->name('files.delete'); // Delete additional information
    Route::get('/files/download/{id}', 'download')->middleware('auth')->name('files.download');

});
Route::controller(PdfController::class)->group(function () {
    Route::get('/download/cv-pdf/{id}', 'downloadPDF')->middleware('auth')->name('view-cv.pdf');
});
Route::controller(FamilyInforamationController::class)->group(function(){
    Route::post('family-inforamation/store','store')->middleware('auth')->name('store.family.info');
    Route::get('/family-member/{id}/edit','edit')->middleware('auth')->name('family-member.edit');
    Route::post('/family-info/update','update')->middleware('auth')->name('family.info.update');
    Route::delete('/family-info/{id}','destroy')->middleware('auth')->name('family-info.destroy');


});
Route::controller(BankInformationController::class)->group(function(){
    Route::post('/bank-info/save', 'save')->name('bank-info.save');
    Route::delete('/bank-info/delete/{id}', 'delete')->name('bank-info.delete');
});
Route::controller(ApplicationController::class)->group(function(){
    Route::get('employee/application-form', 'applicationForm')->middleware('auth')->name('application.add');

});
