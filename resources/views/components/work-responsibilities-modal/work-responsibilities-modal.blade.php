<!-- Edit Professional Skill Modal -->
<div class="modal fade" id="editWorkResponsibilitiesModal" tabindex="-1" aria-labelledby="editProfessionalSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWorkResponsibilitiesModal">Edit Professional Skill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editWorkResponsibilitiesForm">
                    <input type="hidden" id="edit_responsibilities_id" name="id">

                    <!-- User Dropdown -->
                    <div class="form-group mb-3">
                        <label for="edit_user_id">User Name</label>
                        <select id="edit_user_id" name="user_id" class="form-control edit_user_id" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == old('user_id', '') ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skill Description Input -->
                    <div class="form-group mb-3">
                        <label for="edit_skill_description" class="form-label">Work Responsibilities</label>
                        <textarea class="form-control" id="edit_responsibilities" name="responsibilities" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
