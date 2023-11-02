<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comment</title>
</head>
<body>
    @foreach ($hobbies as $hoby)
        <li>{{$loop->iteration}}. {{$hoby}}</li>
    @endforeach
</body>
</html>