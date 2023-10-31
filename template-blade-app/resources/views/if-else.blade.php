<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>
        @if (count($hobbies) == 1)
            i have hobby
        @elseif(count($hobbies) > 1)
            i have hobbies
        @else
            i have no hobby
        @endif
    </p>
</body>
</html>