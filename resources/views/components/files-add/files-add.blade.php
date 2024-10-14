<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Upload File</h2>
            </div>
            <div class="card-body">
                <form id="fileUploadForm">
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
                    <div class="form-group">
                        <label for="file_type">File Type:</label>
                        <select class="form-control" name="file_type" required>
                            <option value="">Select File type</option>

                            @php

                                // Create an array of existing file types for easier checking
                                $existingFileTypes = $fileTypes->pluck('file_type')->toArray();
                                $availableFileTypes = ['CV', 'Appointment Letter', 'NDA']; // Define available file types
                            @endphp

                            @foreach($availableFileTypes as $availableFileType)
                                @if(!in_array($availableFileType, $existingFileTypes)) <!-- Check if the file type already exists -->
                                <option value="{{ $availableFileType }}">{{ $availableFileType }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file">Upload File:</label>
                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload File</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Uploaded Files</h2>
            </div>
            <div class="card-body">
                <table id="fileUploadTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>File Type</th>
                        <th>File Name</th>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var downloadUrl = "{{ route('files.download', ':id') }}"; // Base URL with placeholder for ID

        // Initialize DataTable
        var filetable = $('#fileUploadTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('files.index') }}", // Your route for fetching files
                type: 'GET'
            },
            columns: [
                { data: 'users.name', name: 'users.name' }, // User name column
                { data: 'file_type', name: 'file_type' },   // File type column
                {
                    data: 'file_path',
                    name: 'file_path',
                    render: function(data, type, row) {
                    console.log('data:',row);
                    
                        // Use the file name as a clickable download link
                        return '<a href="' + downloadUrl.replace(':id', row.id) + '" target="_blank" download>' + row.file_path + '</a>';
                    }

                },
                {
                    data: 'actions', // Assuming 'id' is used to identify the file for additional actions
                    name: 'actions',
                }
            ]
        });

        // Handle form submission using AJAX
        $('#fileUploadForm').on('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Create FormData object to send file data
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('files.store') }}", // Your route for file upload
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'File uploaded successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#websiteLinkForm')[0].reset(); // Reset the form
                        // $('#usersTable').DataTable().ajax.reload(); // Reload the DataTable
                    });
                },
                error: function (response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while adding files.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });
        $('#fileUploadTable').on('click', '.file-delete', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("files.delete", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000
                            });
                            filetable.ajax.reload();
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to delete files!'
                            });
                        }
                    });
                }
            });
        });

    });
</script>


