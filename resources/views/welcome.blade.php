<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">


        <title>{{ config('app.name', 'NTmax') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="ba">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #10152b;">
            <div>
                <a href="/">
                    <img src="{{ asset('src/logo1.jfif') }}" style="width: 50%; margin-left: 25%;" alt="">
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <style>
                    h1 {
                        font-family: 'Nunito', sans-serif;
                        font-size: 3rem; /* Puedes ajustar el tamaño según tus preferencias */
                        color: #27BAC3; /* Color celeste */
                        margin-bottom: 1.5rem; /* Añade un margen inferior para separarlo de los botones */
                    }
                </style>
                
                <form class="flex flex-col items-center">
                    @csrf
                    <h1 style="margin-bottom: 10%">NTmax</h1>
                    <x-primary-button class="ms-3 mb-3" style="background-color: #27BAC3; margin-bottom: 8%;">
                        <a href="/login">Inicia Sesión</a>
                    </x-primary-button>
                    <x-primary-button class="ms-3 mb-3" style="background-color: #27BAC3; margin-bottom: 8%;">
                        <a href="/register">Crea una Cuenta</a>
                    </x-primary-button>

                    <span>
                        Únete a una experiencia única!
                    </span>
                </form>
            </div>
            </script>
        </div>
    </body>
</html>
