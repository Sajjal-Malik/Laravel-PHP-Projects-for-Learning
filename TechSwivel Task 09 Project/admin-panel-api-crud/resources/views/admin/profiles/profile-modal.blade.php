<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="profileForm" enctype="multipart/form-data" data-parsley-validate>
            @csrf
            <input type="hidden" name="id" id="profileId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Add/Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="firstName">First Name*</label>
                        <input type="text" class="form-control" name="firstName" id="firstName"
                            data-parsley-required="true" data-parsley-required-message="First name is required.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastName">Last Name*</label>
                        <input type="text" class="form-control" name="lastName" id="lastName"
                            data-parsley-required="true" data-parsley-required-message="Last name is required.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" data-parsley-type="email"
                            data-parsley-required="true" data-parsley-required-message="Email is required."
                            data-parsley-type-message="Enter a valid email address.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phoneNumber">Phone*</label>
                        <input type="text" class="form-control" name="phoneNumber" id="phoneNumber"
                            data-parsley-required="true" data-parsley-required-message="Phone number is required."
                            data-parsley-pattern="^\d{3}-?\d{3}-?\d{4}$"
                            data-parsley-pattern-message="Phone number must be 10 digits, with or without hyphens.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dob">DOB*</label>
                        <input type="date" class="form-control" name="dob" id="dob" data-parsley-required="true"
                            data-parsley-required-message="Date of Birth is required.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="age">Age*</label>
                        <input type="number" class="form-control" name="age" id="age" data-parsley-required="true"
                            data-parsley-required-message="Age is required.">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender*</label>
                        <select name="gender" id="gender" class="form-control" data-parsley-required="true"
                            data-parsley-required-message="Gender is required.">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="picture">Picture</label>
                        <input type="file" class="form-control" name="picture" id="picture" accept="image/*"
                            data-parsley-fileextension="jpg,jpeg,png"
                            data-parsley-fileextension-message="Only images (jpg, jpeg, png) are allowed.">
                        <img id="picturePreview" src="" class="mt-2" style="width: 50px; height: 50px; display: none;">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="3" data-parsley-maxlength="1000"
                            data-parsley-maxlength-message="Bio can be at most 1000 characters."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Profile</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>