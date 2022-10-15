<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body class="antialiased">
    @if(Auth::guard('admin')->check())
        Hello {{Auth::guard('admin')->user()->email}}
    @elseif(Auth::guard('user')->check())
        Hello {{Auth::guard('user')->user()->email}}
    @endif

    @if (!Auth::guard('user')->check())
        <a href="{{ route('user_login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
    @else
        <form action="{{ route('user_logout') }}" method="POST">
            @csrf
            <button type="submit">log out</button>
        </form>
    @endif
    
</body>
</html>
