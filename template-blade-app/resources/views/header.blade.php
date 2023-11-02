<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @isset($title)
        <h1>{{$title}}</h1>
    @else
        <h1>Tidak mengirim title</h1>
    @endisset

    @isset($desc)
        <h1>{{$desc}}</h1>
    @else
        <h1>Tidak mengirim desc</h1>
    @endisset
</body>
</html>