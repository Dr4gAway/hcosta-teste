<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

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
<body class="w-full min-h-screen flex bg-gray-300 flex items-center justify-center">

    <div class="flex flex-col p-4 h-fit w-96 bg-gray-100 rounded-2xl gap-4">
        <span class="text-4xl font-bold text-hcosta-100">Perfil</span>

        <form action="/user-update" method="post" class="flex flex-col gap-2">
            @method('post')
            @csrf

            <div class="flex flex-col">
                <span class="font-bold text-hcosta-100">Nome</span>
                <input type="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="rounded-md px-4 py-2 focus:outline-none focus:ring-2 ring-offset-2 ring-hcosta-300">
            </div>

            <div class="flex flex-col">
                <span class="font-bold text-hcosta-100">Email</span>
                <input type="text" name="email" value="{{ old('email', auth()->user()->email) }}" class="rounded-md px-4 py-2 focus:outline-none focus:ring-2 ring-offset-2 ring-hcosta-300">
            </div>

            <input type="submit" value="Salvar" class="px-4 py-2 bg-hcosta-300 rounded-md text-white font-bold">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>


        <div class="flex justify-between">
            <a class="font-bold text-hcosta-300" href="{{url('/products')}}">Voltar</a>
    
            <form action="/user-delete" method="post">
                @method('post')
                @csrf
                <button class="text-xs px-2 py-1 border-hcosta-200 border-2 rounded-md text-hcosta-200">Deletar conta</button>
            </form>
        </div>

    </div>
</body>
</html>