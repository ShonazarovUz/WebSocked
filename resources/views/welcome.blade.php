<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Vue Chat</title>
    @vite(['resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col" id="app">
        <header class="bg-white shadow">
            <div class="container mx-auto flex items-center justify-between p-4">
                <h1 class="text-lg font-semibold text-gray-800">Chat App</h1>
                <nav>
                    @if (Route::has('login'))
                        @auth
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main class="flex-grow container mx-auto mt-6">
            @auth
                <div id="app" class="bg-white p-6 rounded shadow">
                    <app :is-auth="{{ json_encode(auth()->check()) }}"
                        :user="{{ auth()->check() ? auth()->user() : 'null' }}"></app>
                </div>
            @else
                <p class="text-center text-gray-600">Please log in to access the chat.</p>
            @endauth
        </main>

        <footer class="bg-gray-800 text-gray-200 text-center py-4">
            <p>&copy; 2024 Chat App. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
