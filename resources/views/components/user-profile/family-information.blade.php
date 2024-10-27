<!-- Family Info Modal -->
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
        <div class="card-body">
            <h3 class="card-title">Family Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#family_info_modal"><i class="fa fa-pencil"></i></a></h3>
            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                        <tr>
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
                            <td>{{ $member->name }}</td>  <!-- Displaying member's name -->
                            <td>{{ $member->relationship }}</td>  <!-- Displaying relationship -->
                            <td>{{ \Carbon\Carbon::parse($member->dob)->format('M d, Y') }}</td>  <!-- Displaying formatted DOB -->
                            <td>{{ $member->phone }}</td>  <!-- Displaying phone number -->
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    $(document).ready(function() {
        // Clone family member template on Add More click
        $('.add-more').on('click', function() {
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
        $(document).on('click', '.remove-family-member', function() {
            $(this).closest('.card').remove();
        });
        $("#familyForm").on('submit',function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                    url: '{{route('store.family.info')}}', // The URL for the store method
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // toastr.success("Family members added successfully!", 'Success');
                        console.log(response);
                        debugger;
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'Something went wrong!';
                        toastr.error(errorMessage, 'Error');
                    }
                });
        })
    });
</script>
