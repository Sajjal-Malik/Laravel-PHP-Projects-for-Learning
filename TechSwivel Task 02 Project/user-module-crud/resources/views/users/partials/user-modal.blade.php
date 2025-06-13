<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="userForm" data-parsley-validate>
            @csrf
            <input type="hidden" id="user_id" name="user_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="userModalTitle" class="modal-title">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="firstName" id="firstName" class="form-control mb-2"
                        placeholder="First Name" data-parsley-required="true"
                        data-parsley-required-message="First name is required.">

                    <input type="text" name="lastName" id="lastName" class="form-control mb-2" placeholder="Last Name"
                        data-parsley-required="true" data-parsley-required-message="Last name is required.">

                    <input type="email" name="email" id="email" class="form-control mb-2" placeholder="Email"
                        autocomplete="username" data-parsley-type="email" data-parsley-required="true"
                        data-parsley-required-message="Email is required."
                        data-parsley-type-message="Enter a valid email address.">

                    <input type="password" name="password" id="password" class="form-control mb-2"
                        placeholder="Password" autocomplete="new-password" data-parsley-minlength="6"
                        data-parsley-minlength-message="Password must be at least 6 characters.">

                    <input type="number" name="age" id="age" class="form-control mb-2" placeholder="Age"
                        data-parsley-type="number" data-parsley-type-message="Age must be a number.">

                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control mb-2"
                        placeholder="Phone Number" data-parsley-pattern="^\d{10,15}$"
                        data-parsley-pattern-message="Phone number must be between 10–15 digits.">

                    <textarea name="bio" id="bio" class="form-control mb-2" placeholder="Bio"
                        data-parsley-maxlength="500"
                        data-parsley-maxlength-message="Bio can be at most 500 characters."></textarea>

                    <input type="date" name="dob" id="dob" class="form-control mb-2" placeholder="DOB"
                        data-parsley-required="true" data-parsley-required-message="Date of Birth is required.">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>

    </div>
</div>