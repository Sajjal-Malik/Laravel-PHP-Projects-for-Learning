<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

        <div class="container">

            <h1 class="text-center">REGISTRATION FORM</h1>

            <form action="{{url('/register')}}" method="post">
                @csrf
                
                <x-input type="text" name="name" label="Please Enter your name" placeholder="Enter your name"/>
                <x-input type="email" name="email" label="Please Enter your email" placeholder="Enter your email"/>
                <x-input type="password" name="password" label="Please Enter your password" placeholder="Enter your password"/>
                <x-input type="password" name="password_confirmation" label="Please Confirm your password" placeholder="Confirm your password"/>

                <button type="submit" style="padding-right:100px; padding-left: 100px; " class="btn btn-primary">Submit</button>
            </form>

        </div>


    </body>

</html>