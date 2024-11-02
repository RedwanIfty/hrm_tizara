@extends('layouts.master')
@section('content')

    <!-- Modal to display form data -->
    <div id="confirmModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure you want to submit the application?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Leave Type:</strong> <span id="modal_leave_type"></span></p>
                    <p><strong>Approval ID:</strong> <span id="modal_approval_id"></span></p>
                    <p><strong>Start Date:</strong> <span id="modal_start_date"></span></p>
                    <p><strong>End Date:</strong> <span id="modal_end_date"></span></p>
                    <p><strong>Reason:</strong> <span id="modal_reason"></span></p>
                    <p><strong>Stay Location:</strong> <span id="modal_stay_location"></span></p>
                    <p><strong>Comment:</strong> <span id="modal_comment"></span></p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm & Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leave Application <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leave Application</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Leave Application Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Leave Application Form</h5>
                </div>
                <div class="card-body">
                    <form id="leaveApplicationForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Leave Type -->
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <select class="form-control" id="leave_type" name="leave_type" required>
                                        <option value="" disabled selected>Select Leave Type</option>
                                        @foreach($leaveType as $type)
                                            <option value="{{ $type->l_type_id }}">{{ $type->leave_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Approval ID Dropdown -->
                                <div class="form-group">
                                    <label for="approval_id">Approval ID</label>
                                    <select class="form-control" id="approval_id" name="approval_id" required>
                                        <option value="" disabled selected>Select Approver</option>
                                        @foreach($admin as $approver)
                                            <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                                <!-- Files -->
                                <div class="form-group">
                                    <label for="files">Attach Files</label>
                                    <input type="file" class="form-control" id="files" name="files[]" multiple>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Reason -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                </div>

                                <!-- Stay Location -->
                                <div class="form-group">
                                    <label for="stay_location">Stay Location</label>
                                    <input type="text" class="form-control" id="stay_location" name="stay_location">
                                </div>

                                <!-- Comment -->
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group text-left mt-4">
                            <button type="button" class="btn btn-primary" id="submitButton">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
    <script>
        $(document).ready(function() {

            $('#submitButton').on('click', function() {
                // Populate modal with form data
                $('#modal_leave_type').text($('#leave_type option:selected').text());
                $('#modal_approval_id').text($('#approval_id option:selected').text());
                $('#modal_start_date').text($('#start_date').val());
                $('#modal_end_date').text($('#end_date').val());
                $('#modal_reason').text($('#reason').val());
                $('#modal_stay_location').text($('#stay_location').val());
                $('#modal_comment').text($('#comment').val());

                // Show the modal
                $('#confirmModal').modal('show');
            });

            $('#confirmSubmit').on('click', function() {
                // Submit the form when "Confirm & Submit" is clicked
                $('#leaveApplicationForm').submit();
                $('#confirmationModal').modal('hide');
            });
        });
    </script>


@endsection
