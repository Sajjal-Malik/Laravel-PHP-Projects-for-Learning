<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teas Page</title>
</head>
<body>

    <h2>Teas Data</h2>

    <ul>
        @foreach ($teas as $tea)
            <li>
                <a href="/teas/{{ $tea['id'] }}">{{ $tea['name'] }}</a>
            </li>
        @endforeach
    </ul>
    
</body>
</html>