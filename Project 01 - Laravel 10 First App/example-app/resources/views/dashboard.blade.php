

@foreach ($users as $user) 
        {{-- This is blade template style of writing php inside html files --}}
        <h1> {{ $user['name'] }} </h1>
        <h2> {{ $user['age'] }} </h2>

        @if ($user['age'] < 18)
            <p>User can't drive</p>
        @endif

        <hr>

@endforeach

@Copyright {{ date('Y')}}
