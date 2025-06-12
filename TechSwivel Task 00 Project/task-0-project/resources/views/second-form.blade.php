<x-layout>
    <style>
        form{
            margin: 30px 0 0 550px;
        }
    </style>

    <form action="{{url('/words/counts')}}" method="post">
        @csrf
        <p><label for="word">Enter the word to count</label></p>
        <input type="text" id="word" name="word" /><br><br>
        <p><label for="paragraph">Enter paragraph containing the word:</label></p>
        <textarea id="paragraph" name="paragraph" rows="4"cols="50"></textarea>
        <br>
        <button type="submit">Submit</button>
    </form>


</x-layout>