<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comment</title>
    <style>
        .red{
            color: red;
        }
        .bold{
            font-weight: bold;
        }
    </style>
</head>
<body>
    @foreach ($hobbies as $hoby)
        <li @class(['red', 'bold' => $hoby["love"]])>{{$hoby["name"]}}</li>
    @endforeach
</body>
</html>