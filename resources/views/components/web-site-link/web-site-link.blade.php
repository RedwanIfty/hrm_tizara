<x-web-site-link-modal.web-site-link-modal/>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Update Website Link</h2>
            </div>
            <div class="card-body">
                <form id="websiteLinkForm">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Name:</label>
                        <select class="form-control" name="user_id" id="user_id" required>
                            <option value="">Select Name</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="website_link">Website Link:</label>
                        <input type="url" class="form-control" name="website_link" id="website_link" placeholder="https://example.com" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DataTable for displaying users with website links -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>User List with Website Links</h2>
            </div>
            <div class="card-body">
                <table id="usersTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Website Link</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- DataTables will populate this section -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Submit the form using AJAX
        $('#websiteLinkForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("user.updateWebsiteLink") }}', // Your route to update website link
                method: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Website link updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#websiteLinkForm')[0].reset(); // Reset the form
                        $('#usersTable').DataTable().ajax.reload(); // Reload the DataTable
                    });
                },
                error: function (response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the website link.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });

        // Initialize DataTable to display users and website links
        var usersTable = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("user.list") }}', // Route for fetching user data
            columns: [
                { data: 'name', name: 'name' },
                { data: 'website_link', name: 'website_link', render: function(data, type, row) {
                        // console.log(type);
                        return data ? `<a href="${data}" target="_blank">${data}</a>` : 'N/A';
                    }},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Example for handling edit and delete actions
        $(document).on('click', '.edit-website-link', function () {
            const id = $(this).data('id');

            $.ajax({
                url: '{{ route("user.editWebsiteLink", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    $('.user_id').val(data.id);
                    $('#website_link').val(data.website_link);
                    $('#editWebsiteLinkModal').modal('show'); // Show the modal after loading data
                },
                error: function() {
                    alert('Failed to load data!');
                }
            });
        });
        $('#editWebsiteLinkFormModal').submit(function(e) {
            e.preventDefault();
            const id = $('#user_id').val(); // Get user ID from hidden field

            $.ajax({
                url: '{{ route("user.updateWebsiteLink") }}',
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    // debugger;
                    if (response.message) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Website link updated successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#editWebsiteLinkModal').modal('hide'); // Hide the modal
                            // Reload DataTable or content if needed
                            $('#usersTable').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred!',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update!',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });

        $(document).on('click', '.delete-website-link', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("user.deleteWebsiteLink", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Website link has been deleted.',
                                icon: 'success',
                                timer: 2000
                            });
                            usersTable.ajax.reload();
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Unable to delete website link!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });

</script>
