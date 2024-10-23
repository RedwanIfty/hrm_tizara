<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h1, h2, h3 {
            color: #0056b3;
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
        }

        .section {
            border-top: 2px solid #0056b3;
            margin: 20px 0;
            padding: 10px 0;
        }

        .section h3 {
            margin: 10px 0;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-item span {
            font-weight: bold;
        }

        .portfolio-link {
            color: #0056b3;
            text-decoration: none;
        }

        .portfolio-link:hover {
            text-decoration: underline;
        }

        .profile-image {
            display: block;
            margin: 0 auto 20px; /* Center the image and add space below */
            width: 150px; /* Adjust width as needed */
            height: auto; /* Maintain aspect ratio */
            border-radius: 50%; /* Optional: make image circular */
        }
    </style>
</head>
<body>

<h1>Employee Information of <br>{{ $employeeInformation->name }}</h1>

<!-- Add the image here -->
{{-- In your Blade view file --}}
<img src="{{$imageSrc}}" style="border: 1px solid black;" height="150" width="150">

@isset($employeeInformation)
    <div class="section">
        <h2>1. Personal Information</h2>
        <div class="info-item"><span>Name:</span> {{ $employeeInformation->name }}</div>
        <div class="info-item"><span>Employee Id:</span> {{ $employeeInformation->u_id }}</div>

        <div class="info-item"><span>Date of Birth:</span> {{ $employeeInformation->date_of_birth }}</div>
        <div class="info-item"><span>Address:</span> {{ $employeeInformation->address }}</div>
        <div class="info-item"><span>Contact Number:</span> {{ $employeeInformation->contact_number }}</div>
        <div class="info-item"><span>Email:</span> <a
                href="mailto:{{ $employeeInformation->email }}">{{ $employeeInformation->email }}</a></div>
        <div class="info-item"><span>Nationality:</span>{{ $employeeInformation->nationality }}</div>
        <div class="info-item"><span>Marital Status:</span> {{ $employeeInformation->marital_status }}</div>
    </div>
@endisset

@isset($educationalBackground)

    <div class="section">
        <h2>2. Educational Background</h2>
        <div class="info-item"><span>Highest Degree:</span> {{ $educationalBackground->degree }}</div>
        <div class="info-item"><span>University/Institution:</span> {{ $educationalBackground->university }}</div>
        <div class="info-item"><span>Graduation Year:</span> {{ $educationalBackground->graduation_year }}</div>
        <div class="info-item"><span>Major:</span> {{ $educationalBackground->major }}</div>
        @if($otherQualifications && $otherQualifications->count() > 0)
            <h3>Other Qualifications:</h3>
            <ul>
                @foreach($otherQualifications as $qualification)
                    <li><span>{{ $qualification->qualification_name }} : </span>{{ $qualification->passing_year }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endisset
@isset($workResposibility)

    <div class="section">
        <h2>3. Work Responsibility on Tizaraa</h2>
        @if(!empty(trim($workResposibility->responsibilities)))
            <ul class="mt-3">
                @foreach (array_filter(explode('.', $workResposibility->responsibilities), fn($responsibility) => !empty(trim($responsibility))) as $responsibility)
                    <li>{{ trim($responsibility) }}.</li>
                @endforeach
            </ul>
        @endif
    </div>
@endisset
@if($jobExperiences && $jobExperiences->count() > 0)
    <div class="section">
        <h2>4. Work Experience</h2>
        @foreach($jobExperiences as $key => $experience)
            <div class="info-item">
                <div><strong>Company {{ $key + 1 }}</strong>: {{ $experience->company_name }}</div>
                <div><strong>Designation:</strong> {{ $experience->designation }}</div>
                <div><strong>Start Date:</strong> {{ $experience->date }}</div>
                <div><strong>Key Responsibilities:</strong></div>
                <ul>
                    <li>{!!$experience->key_responsibilities !!}</li> <!-- Convert new lines to <br> -->
                </ul>
            </div>
        @endforeach
    </div>
@endif
@if($professionalSkills && $professionalSkills->count() > 0)

    <div class="section">

        <h2>5. Professional Skills</h2>
        <ul>
            @foreach($professionalSkills as $skill)
                <li><strong>{{ $skill->skill_name }} : </strong>{{ $skill->description }}</li>
            @endforeach
        </ul>

    </div>
@endif
@if($interpersonalSkills && $interpersonalSkills->count() > 0)

    <div class="section">
        <h2>6. Interpersonal Skills</h2>
        <ul>
            @foreach($interpersonalSkills as $skill)
                <li><strong>{{ $skill->skill_name }} : </strong>{{ $skill->description }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if($notableProjects && $notableProjects->count() > 0)

    <div class="section">
        <h2>7. Portfolio</h2>
        <div class="info-item"><span>Website/Portfolio Link:</span>
            <a href="{{ $employeeInformation->website_link }}" target="_blank" rel="noopener noreferrer">
                {{ $employeeInformation->website_link }}
            </a></div>
        <h3>Notable Projects:</h3>
        <ul>
            @foreach($notableProjects as $project)
                <li><strong style="color: black">{{ $project->notable_project_name }}
                        :</strong> {{ $project->notable_project_description }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="section">
    <h2>8. Interests in Learning/Training/Courses</h2>
    @if($learningInterests && $learningInterests->count() > 0)

        <h3>Interest in Learning:</h3>
        <ul>
            @foreach($learningInterests as $interest)
                <li>
                    {{ $interest->interest }}
                </li>
            @endforeach
        </ul>

        <h3>Completed Courses:</h3>
        <ul>
            @foreach($learningInterests as $course)
                <li>
                    {{ $course->completed_course }}
                </li>
            @endforeach

        </ul>
    @endif
</div>
@if($additionalInformations && $additionalInformations->count() > 0)

    <div class="section">
        <h2>9. Additional Information</h2>
        <h3>Languages Known:</h3>
        <ul>
            @foreach($additionalInformations as $info)
                <li>{{ $info->languages_known }} </li>
            @endforeach
        </ul>
        <h3>Hobbies:</h3>
        <ul>
            @foreach($additionalInformations as $info)
                <li>{{ $info->hobbies }} </li>
            @endforeach
        </ul>
        <h3>Volunteer Work:</h3>
        <ul>
            @foreach($additionalInformations as $info)
                <li>{{ $info->volunteer_work }} </li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
