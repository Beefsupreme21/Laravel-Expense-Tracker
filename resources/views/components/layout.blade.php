<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Alpine-JS</title>
        <link rel = "icon" href="{{ asset('images/alpinejs.svg') }}" type = "image/x-icon">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>

    <body>
        <header class="w-full bg-gray-800">
            <a href="/users">Users</a>
            <a href="/expenses">Expenses</a>
        </header>
        <main class="max-w-screen-lg min-h-screen sm:px-16 md:px-24">
            {{ $slot }}
        </main>
    </body>
</html>