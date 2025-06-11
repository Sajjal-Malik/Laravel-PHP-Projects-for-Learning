<x-layout>
    <style>
        form {
            margin: 30px 0 0 550px;
        }
        
        div {
            margin: 30px 0 0 550px;
        }
    </style>

    <form action="{{url('remove/spaces')}}" method="post">
        @csrf
        <p><label for="sentence">Enter your Text Here:</label></p>
        <textarea id="sentence" name="sentence" rows="4" cols="50"></textarea>
        <br>
        <button type="submit">Submit</button>
    </form>

    @if ($data)
        <div>
            <strong>Processed Text:</strong>
            <p>{{ $data->sentence }}</p>
        </div>
    @endif


</x-layout>