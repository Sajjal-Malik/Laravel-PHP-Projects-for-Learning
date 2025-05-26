<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>Customer View</title>
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
            <a href="{{route('customer.create')}}">
                <button style="padding-left: 50px; padding-right: 50px; margin-top: 20px; margin-bottom: 10px;" class="btn btn-primary" type="submit">Add</button>
            </a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td> {{ $customer->name }} </td>
                            <td> {{ $customer->email }} </td>
                            <td>
                                @if ($customer->gender == 'M')
                                    Male
                                @elseif ($customer->gender == 'F')
                                    Female
                                @else
                                    Other
                                @endif
                            </td>
                            <td> {{ $customer->dob }} </td>
                            <td> {{ $customer->address }} </td>
                            <td> {{ $customer->country }} </td>
                            <td> {{ $customer->state }} </td>
                            <td>  
                                @if ($customer->status == '1')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>   
                            <td> 
                                <a href="{{route('customer.delete', ['id' => $customer->customer_id])}}"><button class="btn btn-danger">Delete</button></a>
                                <a href="{{route('customer.edit', ['id' => $customer->customer_id])}}"><button class="btn btn-warning">Edit</button>
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>

</html>