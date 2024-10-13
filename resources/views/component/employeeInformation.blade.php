@include('component.modal.employeeInformationModal')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Create Employee Information</h2>
            </div>
            <div class="card-body">
                <form id="employeeForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">Select Name</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}" selected>{{$user->name }}</option>
                            @endforeach
                          </select>

                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                               value="{{ isset($employeeInformation) && $employeeInformation->date_of_birth ? $employeeInformation->date_of_birth : '' }}"

                      required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address"
                               value="{{ isset($employeeInformation) && $employeeInformation->address ? $employeeInformation->address : '' }}"

                               required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number"
                               value="{{ isset($employeeInformation) && $employeeInformation->
                                 contact_number? $employeeInformation->contact_number : '' }}"

                               required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ isset($employeeInformation) && $employeeInformation->email ? $employeeInformation->email:'' }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality:</label>
                        <input type="text" class="form-control" id="nationality" name="nationality"
                               value="{{ isset($employeeInformation) && $employeeInformation->nationality ? $employeeInformation->nationality:'' }}"

                               required>
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status:</label>
                        <input type="text" class="form-control" id="marital_status" name="marital_status"
                               value="{{ isset($employeeInformation) && $employeeInformation->marital_status ? $employeeInformation->marital_status:'' }}"

                               required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div id="message" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Information</h2>
            </div>
            <div class="card-body">
                <table id="employeeTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Nationality</th>
                            <th>Marital Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
