@extends('layout.main')

@push('title')
    <title>Home</title>
@endpush

@section('main-section')

    <h1 class="text-center">This is our Home page</h1>

    {{-- <h1>Welcome, {{ $name ?? "Guest" }}</h1> --}}

    {{-- {{ $demo }} --}}

    {{-- {!! $demo !!} --}}

    {{-- @if ($name == "")
            {{ "No name passed so by default Guest is printed" }}
    @elseif($name == "Malik")
    {{ "Correct name is passed" }}
    @else
    {{ "In Correct name is passed" }}
    @endif --}}

    {{-- @unless($name == "Malik")
            {{ "Correct name is not passed" }}
    @endunless --}}

    {{-- @isset($name)
            <h1>Weclome again, {{$name}} </h1>
    @endisset --}}

    {{-- @php
            $arr = [1,2,3,4,5];
        @endphp

        @foreach ($arr as $i)
            <h2>{{$i}}</h2>
    @endforeach --}}


    {{-- @php
            $countries_array = ['England','USA','Pakistan','China',"Germany","Switzerland"];
        @endphp

        <select name="" id="">
            @foreach ($countries_array as $country)
                <option value=""> {{ $country }} </option>
    @endforeach
    </select> --}}

@endsection