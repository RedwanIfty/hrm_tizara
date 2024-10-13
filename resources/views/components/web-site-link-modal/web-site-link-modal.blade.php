<!-- Modal for Editing Website Link -->
<div class="modal fade" id="editWebsiteLinkModal" tabindex="-1" role="dialog" aria-labelledby="editWebsiteLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebsiteLinkModalLabel">Edit Website Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editWebsiteLinkFormModal">
                    @csrf
                    @method('PUT') <!-- For Laravel PUT request -->

                    <input type="hidden" id="user_id" class="user_id" name="user_id">

                    <div class="form-group">
                        <label for="website_link">Website Link:</label>
                        <input type="url" class="form-control" id="website_link" name="website_link" placeholder="Enter website link" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
