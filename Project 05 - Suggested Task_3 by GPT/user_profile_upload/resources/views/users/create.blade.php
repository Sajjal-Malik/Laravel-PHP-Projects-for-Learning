<!-- Create/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="userForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Create User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" name="firstName" required data-parsley-pattern="^[a-zA-Z\s]+$" autocomplete="given-name">
            </div>

            <div class="col-md-6">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" name="lastName" required data-parsley-pattern="^[a-zA-Z\s]+$" autocomplete="family-name">
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required data-parsley-type="email" autocomplete="username">
            </div>

            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required minlength="6" autocomplete="new-password">
            </div>

            <div class="col-md-3">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control" name="age" required data-parsley-type="digits" min="1">
            </div>

            <div class="col-md-3">
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input type="text" class="form-control" name="phoneNumber" required data-parsley-pattern="^\+?[0-9\s\-]{7,15}$">
            </div>

            <div class="col-md-6">
              <label for="DOB" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" name="DOB" required>
            </div>

            <div class="col-12">
              <label for="bio" class="form-label">Bio</label>
              <textarea class="form-control" name="bio" rows="2" required></textarea>
            </div>

            <div class="col-12">
              <label for="profileImage" class="form-label">Profile Image</label>
              <input type="file" class="form-control" name="profileImage" accept="image/*" data-parsley-filemaxmegabytes="2" data-parsley-trigger="change">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="saveUserBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
