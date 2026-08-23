```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SiAlatKu')) — Panel Petugas</title>
    <meta name="description" content="@yield('meta_description', 'SiAlatKu adalah sistem informasi peminjaman alat untuk mengelola permintaan, persetujuan, dan pengembalian alat secara digital.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2216%22 fill=%22%234F46E5%22/><text x=%2250%22 y=%2266%22 font-size=%2254%22 text-anchor=%22middle%22 fill=%22%23FFFFFF%22 font-family=%22monospace%22>S</text></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Public Sans', system-ui, sans-serif;
        }

        .font-mono {
            font-family: 'IBM Plex Mono', ui-monospace, monospace;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">

    <!-- Subtle Ambient Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">

        <!-- Navbar Petugas -->
        @include('layouts.navbar-petugas')

        <!-- Content column -->
        <div class="flex flex-col flex-1 min-w-0 md:pl-72">

            <!-- Dynamic Header -->
            @hasSection('header')
                <header class="bg-white border-b border-slate-200 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Main Content -->
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-auto border-t border-slate-200 bg-white py-4 text-center text-xs text-slate-500">
                <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">

                    <p>
                        &copy; {{ date('Y') }}
                        <span class="font-semibold text-slate-700">
                            {{ config('app.name', 'SiAlatKu') }}
                        </span>.
                        Hak Cipta Dilindungi.
                    </p>

                    <div class="flex items-center space-x-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>

                        <span class="text-slate-600 font-medium">
                            Sistem Operasional Aktif
                        </span>

                        <span class="text-slate-400 font-mono ml-2">
                            v1.0
                        </span>
                    </div>

                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')

</body>
</html>
```
