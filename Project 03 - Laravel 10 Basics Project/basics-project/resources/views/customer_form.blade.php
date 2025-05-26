<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Registration Form</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
            }

            h2 {
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

            input,
            select {
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
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{url('/register')}}">Register</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{url('/customer')}}">Customer</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h2>{{$title}}</h2>

        <form action="{{$url}}" method="post">
            @csrf
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{$customer->name}}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{$customer->email}}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="{{$customer->address}}">

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
            <input type="text" id="state" name="state" value="{{$customer->state}}">

            <label>Gender</label>
            <div class="gender-options">
                <label><input type="radio" name="gender" value="M" {{ $customer->gender == 'M' ? 'checked' : ''}} required> Male</label>
        
                <label><input type="radio" name="gender" value="F" {{ $customer->gender == 'F' ? 'checked' : ''}} required> Female</label>
                
                <label><input type="radio" name="gender" value="O" {{ $customer->gender == 'O' ? 'checked' : ''}} required> Other</label>
            </div>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="{{$customer->dob}}" required>

            <button type="submit">Register</button>
        </form>

    </body>

</html>