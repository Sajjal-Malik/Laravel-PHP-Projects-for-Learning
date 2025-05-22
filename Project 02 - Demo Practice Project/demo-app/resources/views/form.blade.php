<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>

    <body>

        <form action="{{ url('/')}}/register" method="post">

            @csrf

            {{-- <pre>

                @php
                    print_r($errors->all());
                @endphp

            </pre> --}}

            @php
                $demo = 4;
            @endphp

            <div class="container">

                <h1 class="text-center">Registration</h1>

                    <x-input label="Please enter your Name" type="text" name="name" placeholder="Enter your name" :demo=$demo/>
                    <x-input label="Please enter your Email" type="email" name="email" placeholder="Enter your email"/>
                    <x-input label="Please enter your Password" type="password" name="password" placeholder="Enter your password"/>
                    <x-input label="Please Confirm your Password" type="password" name="password_confirmation" placeholder="Enter your password again"/>

                <button class="btn btn-primary">Submit Form</button>

            </div>
        </form>








        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </body>

</html>