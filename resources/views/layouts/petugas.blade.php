<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SiAlatKu') }} - Panel Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full text-slate-100 bg-slate-950">
    <div class="min-h-screen">

        <!-- Navbar Petugas 4K -->
        @include('layouts.navbar-petugas')

        <!-- Header Dynamic -->
        @if (isset($header))
            <header class="bg-slate-900/60 border-b border-slate-800 backdrop-blur-md">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Content Slot -->
        <main>
            {{ $slot }}
        </main>

    </div>
</body>
</html>