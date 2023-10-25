<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="/form">
        @csrf
        <input type="text" name="name"/>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>