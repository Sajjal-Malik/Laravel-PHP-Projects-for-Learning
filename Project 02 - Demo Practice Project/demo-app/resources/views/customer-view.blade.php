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
        <x-navbar />

        <div class="container">

            {{-- <pre>
            {{ print_r($customers) }}
            </pre> --}}

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
                            <td> {{ $customer->status == '1' ? "Active" : "Away" }} </td>
                            <td> 
                                {{-- <a href="{{url('/customer/delete')}}/{{$customer->customer_id}}"><button class="btn btn-danger">Delete</button></a> --}}
                                <a href="{{route('customer.delete', ['id'=> $customer->customer_id])}}"><button class="btn btn-danger">Delete</button></a>

                                <a href="{{route('customer.edit', ['id'=> $customer->customer_id])}}"><button class="btn btn-primary">Edit</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    </body>

</html>