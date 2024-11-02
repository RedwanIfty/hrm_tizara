@php use Carbon\Carbon; @endphp
    <!-- Family Info Modal -->
<style>
    .scrollable-content {
        max-height: 200px; /* Adjust height as needed */
        overflow-y: auto;
    }

</style>
<!-- Edit Family Info Modal -->
<div id="edit_family_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Family Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editFamilyForm">
                    @csrf
                    <input type="hidden" name="member_id" id="editFamilyId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" id="editFamilyName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Relationship <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="relationship" id="editFamilyRelationship">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="dob" id="editFamilyDob">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="phone" id="editFamilyPhone">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Family Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="familyForm">
                    @csrf
                    <div class="form-scroll" id="family-info-container">
                        <!-- Family Member Template (Hidden) -->
                        <div class="card family-member-template">
                            <div class="card-body">
                                <h3 class="card-title">Family Member
                                    <a href="javascript:void(0);" class="delete-icon remove-family-member">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </h3>
                                <div class="row">
                                    <input type="hidden" value="{{$user}}" name="user_id">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="relationship[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="dob[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="phone[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Family Member Template -->
                    </div>

                    <!-- Add More Button -->
                    <div class="add-more text-left mt-3">
                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>

                    <div class="submit-section mt-3">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body scrollable-content">
            <h3 class="card-title">Family Informations <a href="#" class="edit-icon" data-toggle="modal"
                                                          data-target="#family_info_modal"><i class="fa fa-pencil"></i></a>
            </h3>
            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Date of Birth</th>
                        <th>Phone</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($familyInformations as $member)
                        <tr>
                            <td>{{$member->id}}</td>
                            <td>{{ $member->name }}</td>  <!-- Displaying member's name -->
                            <td>{{ $member->relationship }}</td>  <!-- Displaying relationship -->
                            <td>{{ Carbon::parse($member->dob)->format('M d, Y') }}</td>
                            <!-- Displaying formatted DOB -->
                            <td>{{ $member->phone }}</td>  <!-- Displaying phone number -->
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle"
                                       href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0);"
                                           class="dropdown-item edit-family-btn"
                                           data-id="{{ $member->id }}">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>

                                        <a href="#" class="dropdown-item delete-family-btn" data-id="{{ $member->id }}"><i
                                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Clone family member template on Add More click
        $('.add-more').on('click', function () {
            // Clone the family member template
            let newMember = `
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Family Member
                            <a href="javascript:void(0);" class="delete-icon remove-family-member">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Relationship <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="relationship[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="dob[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="phone[]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#family-info-container').append(newMember);
        });

        // Remove family member section
        $(document).on('click', '.remove-family-member', function () {
            $(this).closest('.card').remove();
        });
        $("#familyForm").on('submit', function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: '{{route('store.family.info')}}', // The URL for the store method
                type: 'POST',
                data: formData,
                success: function (response) {
                    // toastr.success("Family members added successfully!", 'Success');
                    console.log(response);
                    // debugger;
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'Something went wrong!';
                    toastr.error(errorMessage, 'Error');
                }
            });
        });
        $("#editFamilyForm").on('submit', function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: '{{route('family.info.update')}}', // The URL for the store method
                type: 'POST',
                data: formData,
                success: function (response) {
                    // toastr.success("Family members added successfully!", 'Success');
                    console.log(response);
                    // debugger;
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (xhr) {
                    // Parse and display error message
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // If there are multiple validation errors, join them
                        errorMessage = Object.values(xhr.responseJSON.errors).join(', ');
                    }

                    // Display error message with toastr
                    toastr.error(errorMessage, 'Error');
                    console.error("Error response:", xhr); // Log the entire error response for debugging
                }

            });
        });

        $(document).on('click', '.edit-family-btn', function () {
            let familyId = $(this).data('id');

            // AJAX request to fetch family data
            $.ajax({
                url: '{{ route("family-member.edit", ":id") }}'.replace(':id', familyId),   // Define the route name in web.php
                type: 'GET',
                data: {id: familyId},
                success: function (data) {
                    console.log(data);
                    $('#editFamilyId').val(data.id);
                    $('#editFamilyName').val(data.name);
                    $('#editFamilyRelationship').val(data.relationship);
                    $('#editFamilyDob').val(data.dob);
                    $('#editFamilyPhone').val(data.phone);
                    $('#edit_family_info_modal').modal('show');
                },
                error: function () {
                    toastr.error('Failed to fetch data', 'Error');
                }
            });
        });

        $(document).on('click', '.delete-family-btn', function () {
            let memberId = $(this).data('id');
            let row = $(`#member-${memberId}`);

            // Show a toast alert to confirm deletion
            toastr.warning('Are you sure you want to delete this family member?', 'Confirm Deletion', {
                closeButton: true,
                progressBar: true,
                tapToDismiss: false,
                timeOut: 0 // Keeps the toast visible until the user closes it
            });

            // Add custom buttons for confirm and cancel
            toastr.options.onclick = function () {
                // When clicked, proceed with deletion
                let url = `{{ route('family-info.destroy', ':id') }}`.replace(':id', memberId);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            row.remove();  // Remove the row from the table
                        } else {
                            toastr.error(response.message);
                        }
                        location.reload();
                    },
                    error: function () {
                        toastr.error('Failed to delete family member.');
                    }
                });
            };

            // This will add a cancel button to close the toast
            toastr.options.onHidden = function () {
                // Optionally, you can do something when the toast is closed
            };
        });


    });
</script>
