<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/login" method="post">
        @csrf
        <label>Username: @error('username') {{ $message }} @enderror <input type="text" name="username"></label><br>
        <label>Password: @error('password') {{ $message }} @enderror <input type="text" name="password"></label><br>
        <input type="submit" value="Login"><br>
    </form>

</body>
</html>