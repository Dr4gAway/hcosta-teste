<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hcosta': {
                            100: '#40162A',
                            200: '#AB2C43',
                            300: '#FD6043',
                        }
                    }
                }
            }
        }
    </script>
</head>
<header class="flex justify-center h-[80px] py-4 bg-white">
    <nav class="flex justify-between max-w-[1080px] w-full">
        <div class="flex gap-4 items-center">
            <span class=" self-center text-3xl font-extrabold">HCosta</span>
            <a href="{{ url('/products') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Produtos</a>
        </div>
        @if (Route::has('login'))
            <div class="flex gap-4 items-center">
                @auth
                    @if (Auth::user() && Auth::user()->admin)
                        <a href="{{ url('/orders/all') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin</a>
                        
                    @endif
                    <a href="{{ url('/orders') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Pedidos</a>
                    <a href="{{ url('/cart') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Carrinho</a>
                    <a href="{{ url('/user-update') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Perfil</a>
                    <form action="/logout" method="post">
                        @method('post')
                        @csrf
                        <button class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('signup'))
                        <a href="{{ route('signup') }}" class="ml-4 font-semibold text-gray-600 hover:text-hcosta-300 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Sign up</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>
</header>

<body class="bg-gray-300">