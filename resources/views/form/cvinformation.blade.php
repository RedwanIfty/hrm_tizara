@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
               <div class="employee-info">
                   <h3>Employee Information</h3>
                    <div class="image-container">
                        @isset($employeeInformation->avatar)
                        <img src="{{ asset('/assets/images/' . $employeeInformation->avatar) }}" alt="Profile Image"/>
                    @else
                        <img src="{{ asset('/assets/images/default.png') }}" alt="Default Image"/>
                    @endisset
                    
                    </div>
                   <div class="row">
                       <!-- Personal Information -->
                       @isset($employeeInformation)
                           <div class="col-lg-4">
                               <h4>Personal Information</h4>
                               <ul>
                                   <li><span>Name : </span>{{ $employeeInformation->name }}</li>
                                   <li><span>Date of Birth: </span>{{ $employeeInformation->date_of_birth }}</li>
                                   <li><span>Address : </span>{{ $employeeInformation->address }}</li>
                                   <li><span>Contact Number : </span>{{ $employeeInformation->contact_number }}</li>
                                   <li>
                                    <span>Email : </span>
                                    <a href="mailto:{{ $employeeInformation->email }}">{{ $employeeInformation->email }}</a>
                                </li>
                                
                                   <li><span>Nationality : </span>{{ $employeeInformation->nationality }}</li>
                                   <li><span>Marital Status : </span>{{ $employeeInformation->marital_status }}</li>
                               </ul>
                           </div>
                       @endisset

                       <!-- Educational Background -->
                       @isset($educationalBackground)
                           <div class="col-lg-4">
                               <h4>Educational Background</h4>
                               <ul>
                                   <li><span>Highest Degree : </span>{{ $educationalBackground->degree }}</li>
                                   <li><span>University/Institution: </span>{{ $educationalBackground->university }}</li>
                                   <li><span>Graduation Year : </span>{{ $educationalBackground->graduation_year }}</li>
                                   <li><span>Major : </span>{{ $educationalBackground->major }}</li>
                                   @if($otherQualifications && $otherQualifications->count() > 0)
                                   <li><span>Other Qualifications</span></li>      
                                   <ul>
                                        @foreach($otherQualifications as $qualification)
                                            <li><span>{{ $qualification->qualification_name }} : </span>{{ $qualification->passing_year }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                               </ul>
                              
                           </div>
                       @endisset

                       <!-- Work Responsibility -->
                       @isset($workResposibility)
                           <div class="col-lg-4">
                               <h4>Work Responsibility In Tizaraa</h4>
                               @if(!empty(trim($workResposibility->responsibilities)))
                                   <ul class="mt-3">
                                       @foreach (array_filter(explode('.', $workResposibility->responsibilities), fn($responsibility) => !empty(trim($responsibility))) as $responsibility)
                                           <li>{{ trim($responsibility) }}.</li>
                                       @endforeach
                                   </ul>
                               @endif
                           </div>
                       @endisset

                       <!-- Work Experience -->
                       @if($jobExperiences && $jobExperiences->count() > 0)
                           <div class="col-lg-4">
                               <h4>Work Experience</h4>
                               @foreach($jobExperiences as $key=>$experience)
                                   <ul>
                                       <span>Company {{++$key}}</span>
                                        <ul>
                                            <li><span>Company Name: </span>{{ $experience->company_name }}</li>
                                            <li><span>Designation : </span>{{ $experience->designation }}</li>
                                            <li><span>Start Date : </span>{{ $experience->date }}</li>
                                            <li>
                                                <span>
                                                    Key Responsibility : 
                                                </span>
                                                {!! $experience->key_responsibilities !!}
                                            </li>
                                           
                                        </ul>   
                                    </ul>
                               @endforeach
                           </div>
                       @endif

                       <!-- Professional Skills -->
                       @if($professionalSkills && $professionalSkills->count() > 0)
                           <div class="col-lg-4">
                               <h4>Professional Skills</h4>
                               <ul>
                                   @foreach($professionalSkills as $skill)
                                       <li><span>{{ $skill->skill_name }} : </span>{{ $skill->description }}</li>
                                   @endforeach
                               </ul>
                           </div>
                       @endif

                       <!-- Interpersonal Skills -->
                       @if($interpersonalSkills && $interpersonalSkills->count() > 0)
                           <div class="col-lg-4">
                               <h4>Interpersonal Skills</h4>
                               <ul>
                                   @foreach($interpersonalSkills as $skill)
                                       <li><span>{{ $skill->skill_name }} : </span>{{ $skill->description }}</li>
                                   @endforeach
                               </ul>
                           </div>
                       @endif

                       <!-- Portfolio -->
                       @if($notableProjects && $notableProjects->count() > 0)
                           <div class="col-lg-4">
                               <h4>Portfolio</h4>
                               <ul>
                                <li>
                                    <span>Website/Portfolio Link: </span>
                                    <a href="{{ $employeeInformation->website_link }}" target="_blank" rel="noopener noreferrer">
                                        {{ $employeeInformation->website_link }}
                                    </a>
                                </li>
                                
                                   <span>Notable Projects</span>
                                   <ul>
                                        @foreach($notableProjects as $project)
                                        <li><span style="color: black">{{ $project->notable_project_name }} :</span> {{ $project->notable_project_description }}</li>
                                    @endforeach
                                   </ul>
                               </ul>
                           </div>
                       @endif

                       <!-- Learning Interests -->
                       @if($learningInterests && $learningInterests->count() > 0)
                       <div class="col-lg-4">
                        <h4>Interests in Learning/Training/Courses</h4>
                        <ul>
                            @foreach($learningInterests as $interest)
                                <li>
                                    <span>Interest in Learning: </span>{{ $interest->interest }} <br>
                                    <span>Completed Courses: </span>{{ $interest->completed_course }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                     @endif

                       <!-- Additional Information -->
                       @if($additionalInformations && $additionalInformations->count() > 0)
                       <div class="col-lg-4">
                        <h4>Additional Information</h4>
                        <ul>
                            @foreach($additionalInformations as $info)
                                <li>
                                    <span>Languages Known: </span>{{ $info->languages_known }} <br>
                                    <span>Hobbies: </span>{{ $info->hobbies }} <br>
                                    <span>Volunteer Work: </span>{{ $info->volunteer_work }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                   </div>
               </div>
           </div>
       </div>
   </div>
   <style>
        .employee-info img {
            width: 200px;
            height: 200px;
            border-radius: 100%;
            border: 8px solid #93c9ff;
            margin-bottom: 10px;
            text-align: center;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        }
        .employee-info ul span {
            font-size: 18px;
            color: #001c39;
            list-style-type: disc; /* Default bullet points */

            font-weight: 800;
        }
        .employee-info h4 {
            background: #cee3f8;
            padding: 15px 30px;
            border-radius: 50px;
            text-align: center;
        }
        .employee-info ul li {
            list-style: none;
            list-style-type: disc; /* Default bullet points */

            margin-bottom: 6px;
            font-size: 18px;
        }
        .employee-info ul li span {
            font-size: 16px;
            color: #001c39;
            list-style-type: disc; /* Default bullet points */

            font-weight: 800;
        }

   </style>
@endsection
