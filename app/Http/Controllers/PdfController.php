<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInformation;
use App\Models\EducationBackground;
use App\Models\InterpersonalSkill;
use App\Models\JobExperience;
use App\Models\LearningInterest;
use App\Models\NotableProject;
use App\Models\OtherQualification;
use App\Models\ProfessionalSkill;
use App\Models\User;
use App\Models\WorkResponsibility;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
    public function downloadPDF($id)
    {
        $authUser = auth()->user();

        // Check if the user is authorized to view the CV
        if ($authUser->id != $id && !($authUser->role_name=="Admin")) {
            // If not the user or not an admin, abort with a 403 error
            abort(403, 'Unauthorized access to this CV.');
        }

        // Create an instance of mPDF
        $mpdf = new Mpdf();

        // Increase backtrack limit
        ini_set("pcre.backtrack_limit", "50000000000");

        // Find the user and prepare the image path
        $user = User::find($id);
        $imagePath = public_path('assets/images/' . ($user->avatar !== 'photo_defaults.jpg' ? $user->avatar : '720442987.png'));

        // Encode the image data to base64
        $base64 = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $base64;

        // Fetch employee information
        $employeeInformation = DB::table('users')
            ->leftJoin('employee_information', 'employee_information.user_id', '=', 'users.id')
            ->where('employee_information.user_id', $id)
            ->where('employee_information.is_delete', 0)
            ->select('users.*', 'employee_information.*','users.user_id as u_id')
            ->first();
//        return $employeeInformation;

        // Format date of birth
        if (!empty($employeeInformation->date_of_birth)) {
            $employeeInformation->date_of_birth = Carbon::parse($employeeInformation->date_of_birth)->format('jS F Y');
        }

        // Eager load educational background and format graduation year
        $educationalBackground = EducationBackground::where('user_id', $id)->where('is_delete', 0)->first();
        if ($educationalBackground) {
            $educationalBackground->graduation_year = !empty($educationalBackground->graduation_year) ?
                Carbon::parse($educationalBackground->graduation_year)->format('jS F Y') : null;
        }

        $otherQualifications = OtherQualification::where('user_id', $id)->where('is_delete',0)->get();
        foreach ($otherQualifications as $qualification) {
            if (!empty($qualification->passing_year)) {
                $qualification->passing_year = Carbon::parse($qualification->passing_year)->format('jS F Y');
            }
        }

        $jobExperiences = JobExperience::where('user_id', $id)->where('is_delete', 0)->get()->each(function ($jobExperience) {
            $jobExperience->date = Carbon::parse($jobExperience->date)->format('jS F Y');
        });
        $workResposibility = WorkResponsibility::where('user_id', $id)->where('is_delete',0)->first();

        // Fetch professional and interpersonal skills
        $professionalSkills = ProfessionalSkill::where('user_id', $id)->where('is_delete', 0)->get();
        $interpersonalSkills = InterpersonalSkill::where('user_id', $id)->where('is_delete', 0)->get();
        $notableProjects = NotableProject::where('user_id', $id)->where('is_delete', 0)->get();
        $learningInterests = LearningInterest::where('user_id', $id)->where('is_delete', 0)->get();
        $additionalInformations = AdditionalInformation::where('user_id', $id)->where('is_delete', 0)->get();

        // Render the HTML view
        $html = view('cv.pdf', compact('imageSrc', 'employeeInformation', 'educationalBackground', 'otherQualifications',
            'jobExperiences', 'professionalSkills', 'interpersonalSkills', 'notableProjects', 'learningInterests','workResposibility',
            'additionalInformations'))->render();

        // Write HTML to the PDF
        $mpdf->WriteHTML($html);

        // Output to browser for download
        $mpdf->Output('my_pdf.pdf', 'I'); // 'D' for download, 'I' to open in browser
    }

}
