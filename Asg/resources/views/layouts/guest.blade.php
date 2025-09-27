<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white-500 from-indigo-500 via-purple-500 to-pink-500">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/" wire:navigate>
                <x-application-logo class="w-50 h-20 text-white drop-shadow-lg" />
            </a>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-900 shadow-2xl rounded-2xl transform transition-all hover:scale-[1.02] hover:shadow-indigo-500/50">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
