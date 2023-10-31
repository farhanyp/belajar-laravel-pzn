<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- Bisa terkena XSS --}}
    {{-- Tidak menggunakan Special Character --}}
    <h1>{{!!$name!!}}}</h1>

    {{-- Menggunakan Special Character --}}
    <h1>{{!!$name!!}}}</h1>
</body>
</html>