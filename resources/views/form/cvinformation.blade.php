@extends('layouts.master')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">Employee Information</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-left">
                        <img src="{{ asset('assets/images/' . $employeeInformation->avatar) }}" alt="No Image" class="img-fluid" style="width: 150px; height: 150px;">
                    </div>
                    <hr>

                    <h4 class="card-title">1. Personal Information</h4>
                    <ul class="mt-3">
                        <li><strong>Name:</strong> {{$employeeInformation->name}}</li>
                        <li><strong>Date of Birth:</strong> {{$employeeInformation->date_of_birth}}</li>
                        <li><strong>Address:</strong> {{$employeeInformation->address}}</li>
                        <li><strong>Contact Number:</strong> {{$employeeInformation->contact_number}}</li>
                        <li>
                            <strong>Email:</strong>
                            <a href="mailto:{{ $employeeInformation->email }}">{{ $employeeInformation->email }}</a>
                        </li>
                        <li><strong>Nationality:</strong> {{$employeeInformation->nationality}}</li>
                        <li><strong>Marital Status:</strong> {{$employeeInformation->marital_status}}</li>
                    </ul>
                    <hr>

                    <h4 class="card-title">2. Educational Background</h4>
                    @isset($educationalBackground)
                        <ul class="mt-3">
                            <li><strong>Highest Degree:</strong> {{$educationalBackground->degree ?? 'N/A'}}</li>
                            <li><strong>University/Institution:</strong> {{$educationalBackground->university ?? 'N/A'}}</li>
                            <li><strong>Graduation Year:</strong> {{$educationalBackground->graduation_year ?? 'N/A'}}</li>
                            <li><strong>Major:</strong> {{$educationalBackground->major ?? 'N/A'}}</li>
                        </ul>
                    @endisset

                    @if(isset($otherQualifications) && count($otherQualifications) > 0)
                        <li><strong>Other Qualifications:</strong>
                            <ul>
                                @foreach ($otherQualifications as $otherQualification)
                                    <li>{{$otherQualification->qualification_name}} ({{$otherQualification->passing_year}})</li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <hr>

                    <h4 class="card-title">3. Work Responsibility In Tizaraa</h4>
                    @isset($workResposibility)
                        @if(!empty(trim($workResposibility->responsibilities)))
                            <ul class="mt-3">
                                @foreach (explode('.', $workResposibility->responsibilities) as $responsibility)
                                    @if(trim($responsibility) != '')
                                        <li>{{ trim($responsibility) }}.</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    @endisset
                    <hr>

                    <h4 class="card-title">4. Work Experience</h4>
                    @if(isset($jobExperiences) && count($jobExperiences) > 0)
                        <ul class="mt-3">
                            @foreach($jobExperiences as $key => $jobExperience)
                                <li><strong>Company:</strong> Company {{ ++$key }}</li>
                                <li><strong>Designation:</strong> {{$jobExperience->designation}}</li>
                                <li><strong>Company Name: </strong> {{$jobExperience->company_name}}</li>
                                <li><strong>Start Date: </strong> {{$jobExperience->date}}</li>
                                <li><strong>Key Responsibility: </strong>
                                    <ul>
                                        {!! $jobExperience->key_responsibilities !!}
                                    </ul>
                                </li>
                                <br>
                            @endforeach
                        </ul>
                    @endif
                    <hr>

                    <h4 class="card-title">5. Professional Skills</h4>
                    @if(isset($professionalSkills) && count($professionalSkills) > 0)
                        <ul class="mt-3">
                            @foreach($professionalSkills as $skill)
                                <li><strong>{{$skill->skill_name}}:</strong> {{$skill->description}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <hr>

                    <h4 class="card-title">6. Interpersonal Skills</h4>
                    @if(isset($interpersonalSkills) && count($interpersonalSkills) > 0)
                        <ul class="mt-3">
                            @foreach($interpersonalSkills as $skill)
                                <li><strong>{{$skill->skill_name}}:</strong> {{$skill->description}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <hr>

                    <h4 class="card-title">7. Portfolio</h4>
                    @isset($employeeInformation->website_link)
                        <ul class="mt-3">
                            <li>
                                <strong>Website/Portfolio Link:</strong>
                                <a href="{{ $employeeInformation->website_link }}" target="_blank">{{ $employeeInformation->website_link }}</a>
                            </li>
                        </ul>
                    @endisset

                    @if(isset($notableProjects) && count($notableProjects) > 0)
                        <ul class="mt-3">
                            <li>
                                <strong>Notable Projects:</strong>
                                <ul>
                                    @foreach($notableProjects as $project)
                                        <li><strong>{{$project->notable_project_name}}:</strong> {{$project->notable_project_description}}</li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    @endif
                    <hr>

                    <h4 class="card-title">8. Interests in Learning/Training/Courses</h4>
                    @if(isset($learningInterests) && count($learningInterests) > 0)
                        <ul class="mt-3">
                            <li><strong>Interest in Learning:</strong></li>
                            <ul>
                                @foreach($learningInterests as $learningInterest)
                                    <li>{{$learningInterest->interest}}</li>
                                @endforeach
                            </ul>
                            <li><strong>Completed Courses:</strong></li>
                            <ul>
                                @foreach($learningInterests as $learningInterest)
                                    <li>{{$learningInterest->completed_course}}</li>
                                @endforeach
                            </ul>
                        </ul>
                    @endif
                    <hr>

                    <h4 class="card-title">9. Additional Information</h4>
                    @if(isset($additionalInformations) && count($additionalInformations) > 0)
                        <ul class="mt-3">
                            <li><strong>Languages Known:</strong></li>
                            <ul>
                                @foreach($additionalInformations as $additionalInformation)
                                    <li>{{$additionalInformation->languages_known}}</li>
                                @endforeach
                            </ul>
                        </ul>
                        <ul class="mt-3">
                            <li><strong>Hobbies:</strong></li>
                            <ul>
                                @foreach($additionalInformations as $additionalInformation)
                                    <li>{{$additionalInformation->hobbies}}</li>
                                @endforeach
                            </ul>
                        </ul>
                        <ul class="mt-3">
                            <li><strong>Volunteer Work:</strong></li>
                            <ul>
                                @foreach($additionalInformations as $additionalInformation)
                                    <li>{{$additionalInformation->volunteer_work}}</li>
                                @endforeach
                            </ul>
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
