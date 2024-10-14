@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
               <div class="employee-info">
               <h3>Employee Information</h3>
               <img src="{{asset('/assets/images/720442987.png')}}" alt="Image"/>
                <div class="row">
                    <div class="col-lg-4">
                        <h4>Personal Information</h4>
                        <ul>
                            <li><span>Name : </span>Asif Iqbal Chowdhury</li>
                            <li><span>Date of Birth: </span>17th September 2098</li>
                            <li><span>Address : </span>Uttora Dhaka</li>
                            <li><span>Contact Number : </span>01888770707</li>
                            <li><span>Email : </span>asif@gmail.com</li>
                            <li><span>Nationality : </span>Bangladeshi</li>
                            <li><span>Marital Status : </span>Single</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                       <h4>Educational Background</h4>
                       <ul>
                            <li><span>Highest Degree : </span> BSc</li>
                            <li><span>University/Institution: </span>Bangladesh University</li>
                            <li><span>Graduation Year : </span> 2023</li>
                            <li><span>Major : </span>Software Engineer</li>
                        </ul>
                        <ul>
                            <span>Other Qualifications</span>
                            <li><span>HSC : </span>4.22</li>
                            <li><span>SSC : </span>4.32</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Work Responsibility In Tizaraa</h4>
                        <ul>
                            <li>Work one</li>
                            <li>Work Two</li>
                            <li>Work Three</li>
                            <li>Work Four</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Work Experience</h4>
                        <ul>
                            <li><span>Company: </span> Company 1</li>
                            <li><span>Designation : </span>abcd</li>
                            <li><span>Company Name : </span> ITD</li>
                            <li><span>Start Date : </span>01/01/2022</li>
                            <li><span>Key Responsibility : </span>Webdesigner</li>
                        </ul>
                        <ul>
                            <li><span>Company: </span> Company 2</li>
                            <li><span>Designation : </span>efgh</li>
                            <li><span>Company Name : </span> ITD</li>
                            <li><span>Start Date : </span>01/01/2023</li>
                            <li><span>Key Responsibility : </span>Webdesigner</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Professional Skills</h4>
                        <ul>
                            <li><span>programming language: </span> c++ ,c,c#, python,dart</li>
                            <li><span>Skills 1 : </span>a</li>
                            <li><span>Skills 2 : </span>b</li>
                            <li><span>Skills 3 : </span>c</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Interpersonal Skills</h4>
                        <ul>
                            <li><span>Interpersonal 1 : </span>a</li>
                            <li><span>Interpersonal 2 : </span>b</li>
                            <li><span>Interpersonal 3 : </span>c</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Portfolio</h4>
                        <ul>
                            <li><span>Website/Portfolio Link: </span> https://github.com/RedwanIfty</li>
                            <li><span>Notable Projects : </span>a leave management system: Approver can approved reject and modify application.</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Interests in Learning/Training/Courses</h4>
                        <ul>
                            <li><span>Interest in Learning : </span>dsafa</li>
                            <li><span>Completed Courses : </span>asdfc</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4>Additional Information</h4>
                        <ul>
                            <li><span>Languages Known : </span>Bangla, English</li>
                            <li><span>Hobbies : </span>1,2,3,4,5</li>
                            <li><span>Volunteer Work : </span>1,2,3,4,5</li>
                        </ul>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </div>
   <style>
    
        .employee-info img{
            width:200px;
            height:200px;
            border-radius:100%;
            border:8px solid #93c9ff;
            margin-bottom: 10px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        }
        .employee-info ul span{
            font-size:18px;
           color:#001c39;
           font-weight:800;
        }
        .employee-info h4{
           background: #cee3f8;
           padding:15px 30px;
           border-radius:50px;
           text-align:center;
        }
        .employee-info ul li{
           list-style: none;
           margin-bottom: 6px;
           font-size:18px;
        }
        .employee-info ul li span{
           font-size:16px;
           color:#001c39;
           font-weight:800;
        }
   </style>
@endsection
