<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2{
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .gender-options {
            display: flex;
            gap: 10px;
        }
        .gender-options label {
            display: inline;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

<h2>Registration Form</h2>
<form action="{{url('/')}}/customer" method="post">
    @csrf
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <label for="address">Address</label>
    <input type="text" id="address" name="address">

    <label for="country">Country</label>
    <select id="country" name="country">
        <option value="">Select Country</option>
        <option value="usa">United States</option>
        <option value="uk">United Kingdom</option>
        <option value="canada">Canada</option>
        <option value="australia">Australia</option>
        <!-- Add more countries as needed -->
    </select>

    <label for="state">State/Province</label>
    <input type="text" id="state" name="state">

    <label>Gender</label>
    <div class="gender-options">
        <label><input type="radio" name="gender" value="M" required> Male</label>
        <label><input type="radio" name="gender" value="F" required> Female</label>
        <label><input type="radio" name="gender" value="O" required> Other</label>
    </div>

    <label for="dob">Date of Birth</label>
    <input type="date" id="dob" name="dob" required>

    <button type="submit">Register</button>
</form>

</body>
</html>
