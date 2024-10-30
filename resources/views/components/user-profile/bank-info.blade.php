<!-- Display Bank Information -->
<div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">
                Bank Information
            @if(auth()->user())
            <a href="#" class="edit-icon" data-toggle="modal" data-target="#addEditBankModal"><i class="fa fa-pencil"></i></a>
            @endif

            </h3>
            <ul class="personal-info">
                <li>
                    <div class="title">Bank Name</div>
                    <div class="text">{{ $bankInfo->bank_name ?? 'N/A' }}</div>
                </li>
                <li>
                    <div class="title">Bank Account No.</div>
                    <div class="text">{{ $bankInfo->account_number ?? 'N/A' }}</div>
                </li>
                <li>
                    <div class="title">IFSC Code</div>
                    <div class="text">{{ $bankInfo->ifsc_code ?? 'N/A' }}</div>
                </li>
                <li>
                    <div class="title">PAN No</div>
                    <div class="text">{{ $bankInfo->pan_number ?? 'N/A' }}</div>
                </li>
            </ul>
            @if($bankInfo && auth()->user())
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBankModal"><i class="fa fa-trash-o m-r-5"></i></button>
            @endif
        </div>
    </div>
</div>

<!-- Add/Edit Bank Information Modal -->
<div class="modal custom-modal fade" id="addEditBankModal" tabindex="-1" role="dialog" aria-labelledby="addEditBankModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('bank-info.save') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ $bankInfo ? 'Edit' : 'Add' }} Bank Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $bankInfo->id ?? '' }}">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ $bankInfo->bank_name ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" name="account_number" class="form-control" value="{{ $bankInfo->account_number ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>IFSC Code</label>
                        <input type="text" name="ifsc_code" class="form-control" value="{{ $bankInfo->ifsc_code ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>PAN Number</label>
                        <input type="text" name="pan_number" class="form-control" value="{{ $bankInfo->pan_number ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $bankInfo ? 'Update' : 'Save' }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal custom-modal fade" id="deleteBankModal" tabindex="-1" role="dialog" aria-labelledby="deleteBankModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('bank-info.delete', $bankInfo->id ?? '') }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Bank Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this bank information?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o m-r-5"></i></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">*</button>
                </div>
            </form>
        </div>
    </div>
</div>
