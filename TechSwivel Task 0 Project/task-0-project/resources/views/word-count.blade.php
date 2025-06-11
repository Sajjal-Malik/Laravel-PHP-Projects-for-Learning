<x-layout>
    <style>
        div {
            margin: 30px 0 0 550px;
        }
    </style>

    <div>
        @if(isset($count))

            <h2>Word Count Result</h2>
            <p>The word "<strong>{{ $word }}</strong>" appears <strong>{{ $count }}</strong> times in the paragraph.</p>
        @else
            <p>No data to show.</p>
        @endif
    </div>
</x-layout>