<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <form action="/login" method="post">
        @csrf
        <input type="text" name="user" placeholder="User here." />
        <input type="password" name="password" placeholder="Password here." />
        <input type="text" name="birthdate" placeholder="Birthdate here." />
        <input type="submit" value="Send" />
    </form>
    @foreach($errors->all() as $err)
    <div>Erro - {{$err}}</div>
    @endforeach
    @error('user')
    <hr />
    <div>{{$message}}</div>
    @enderror
</body>

</html>