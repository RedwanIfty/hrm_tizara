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
                    <h4 class="card-title">1.Personal Information</h4>
                    <div class="text-left">
                        <img src="{{ asset('assets/images/' . $employeeInformation->avatar) }}" alt="No Image" class="img-fluid" style="width: 150px; height: 150px;">
                    </div>
                    <hr>
                    <ul class="list-unstyled mt-3">
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
                </div>
                <div class="card-body">
                    <h4 class="card-title">1.Personal Information</h4>
                    <div class="text-left">
                        <img src="{{ asset('assets/images/' . $employeeInformation->avatar) }}" alt="No Image" class="img-fluid" style="width: 150px; height: 150px;">
                    </div>
                    <hr>
                    <ul class="list-unstyled mt-3">
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
                </div>
            </div>
        </div>
    </div>
@endsection
