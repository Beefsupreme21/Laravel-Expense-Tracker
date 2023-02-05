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
        <header class="w-full bg-gray-800 flex items-center justify-between p-4">
            <div>
                <a class="text-white font-bold text-xl" href="/users">Users</a>
                <a class="text-white font-bold text-xl ml-4" href="/expenses">Expenses</a>
            </div>
            @auth
              <div class="flex items-center">
                    <span class="text-white font-bold pr-4">Welcome {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="bg-transparent hover:bg-gray-600 text-white font-bold py-2 px-4 border border-white hover:border-transparent rounded">
                        Logout
                    </button>
                    </form>
              </div>
            @else
                <div>
                    <a class="bg-transparent hover:bg-gray-600 text-white font-bold py-2 px-4 border border-white hover:border-transparent rounded mr-2" href="/register">Register</a>
                    <a class="bg-transparent hover:bg-gray-600 text-white font-bold py-2 px-4 border border-white hover:border-transparent rounded" href="/login">Login</a>
                </div>
            @endauth
        </header>

        <main class="max-w-screen-lg min-h-screen px-16 mx-auto">
            {{ $slot }}
        </main>
    </body>
</html>