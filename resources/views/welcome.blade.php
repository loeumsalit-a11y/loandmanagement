<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
</head>
@vite('resources/css/app.css')
<body>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">logout</button>
    </form>
</body>
</html>
