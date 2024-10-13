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
                    
                    <h4 class="card-title">1.Personal Information</h4>
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
                    <h4 class="card-title">2.Educational Background</h4>
                    <ul class="mt-3">
                        <li><strong>Highest Degree:</strong> {{$educationalBackground->degree ?? 'N/A'}}</li>
                        <li><strong>University/Institution:</strong> {{$educationalBackground->university ?? 'N/A'}}</li>
                        <li><strong>Graduation Year:</strong> {{$educationalBackground->graduation_year ?? 'N/A'}}</li>
                        <li><strong>Major:</strong> {{$educationalBackground->major ?? 'N/A'}}</li>
                        <li>
                            <strong>Other Qualifications:</strong>
                                <ul>
                                    {{-- <li>SSC(2016)</li>
                                    <li>HSC(2018)</li> --}}
                                    @foreach ($otherQualifications as $otherQualification)
                                        <li>{{$otherQualification->qualification_name}} ({{$otherQualification->passing_year}})</li>
                                    @endforeach
                                </ul>
                        </li>
                    </ul>
                    <hr>
                    <h4 class="card-title">3.Work Responsibility In Tizaraa</h4>
                    @isset($workResposibility)
                    <ul class="mt-3">
                        @foreach (explode('.', $workResposibility->responsibilities) as $responsibility)
                            @if(trim($responsibility) != '') <!-- Ensure it's not an empty string -->
                                <li>{{ trim($responsibility) }}.</li> <!-- Add period at the end -->
                            @endif
                        @endforeach
                    </ul>
                    @endisset
                    <hr>
                    <h4 class="card-title">4.Work Experience</h4>
                    <ul class="mt-3">
                        @foreach($jobExperiences as $key => $jobExperience)
                            <li><strong>Company:</strong> Company {{ ++$key}}</li>
                            <li><strong>Designation:</strong> {{$jobExperience->designation}}</li>
                            <li><strong>Company Name: </strong> {{$jobExperience->company_name}}</li>
                            <li><strong>Start Date: </strong> {{$jobExperience->date}}</li>
                            <li><strong>Key Responsibility: </strong> 
                                <ul>
                                    {!!$jobExperience->key_responsibilities!!}
                                </ul>
                            </li>

                            <br>
                        @endforeach
                    </ul>
                    <hr>
                    <h4 class="card-title">5.Professional Skills</h4>
                    <ul class="mt-3">
                        @foreach($professionalSkills as $key => $skill)
                            <li><strong>{{$skill->skill_name}}:</strong> {{$skill->description}}</li>
                        @endforeach
                    </ul>
                    <hr>
                    <h4 class="card-title">6.Interpersonal Skills</h4>
                    <ul class="mt-3">
                        @foreach($interpersonalSkills as $key => $skill)
                            <li><strong>{{$skill->skill_name}}:</strong> {{$skill->description}}</li>
                        @endforeach
                    </ul>
                    <hr>
                    <h4 class="card-title">7.Portfolio</h4>
                    <ul class="mt-3">
                        <li>
                            <strong>Website/Portfolio Link:</strong> 
                            <a href="{{ $employeeInformation->website_link }}" target="_blank">
                                {{ $employeeInformation->website_link }}
                            </a>
                        </li>
                        <li>
                            <strong>Notable Projects:</strong>
                            <ul>
                                @foreach($notableProjects as $key => $project)
                                    <li><strong>{{$project->notable_project_name}}:</strong> {{$project->notable_project_description}}</li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
