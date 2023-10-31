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
        @isset($name)
            Hello, My Name is {{$name}}
        @endisset
    </p>

    <p>
        @empty($hobbies)
            I Dont Have Hobbies
        @endempty
    </p>
</body>
</html>