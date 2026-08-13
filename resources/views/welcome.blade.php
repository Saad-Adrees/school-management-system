<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Murray College Portal</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-900 text-white font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header Navigation -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-indigo-600 rounded-lg shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">Murray College Portal</span>
        </div>

        @if (Route::has('login'))
            <nav class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-sm font-semibold transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-lg text-sm font-semibold transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-sm font-semibold transition">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Hero Section -->
    <main class="w-full max-w-7xl mx-auto px-6 py-8 flex-1 flex flex-col lg:flex-row items-center gap-12">
        <!-- Text Content -->
        <div class="flex-1 space-y-6">
            <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full text-xs font-semibold uppercase tracking-wider">
                Government Murray College Sialkot
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight">
                School & Student <span class="text-indigo-400">Management System</span>
            </h1>
            <p class="text-slate-400 text-lg">
                Manage academic records, track daily student attendance, teacher profiles, and generate automated report cards all in one place.
            </p>

            <div class="flex items-center space-x-4 pt-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg font-semibold text-white shadow-lg transition">Go to Dashboard &rarr;</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg font-semibold text-white shadow-lg transition">Access Portal</a>
                @endauth
            </div>
        </div>

        <!-- Murray College Image Container -->
        <div class="flex-1 w-full">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-slate-800 bg-slate-800 group">
                <img 
                    src="{{ asset('images/murray.jpg') }}" 
                    alt="Murray College Sialkot" 
                    class="w-full h-[380px] sm:h-[450px] object-cover transition duration-500 group-hover:scale-105"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1200&q=80';"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4 p-4 rounded-xl bg-slate-900/80 backdrop-blur-md border border-slate-700/50">
                    <p class="text-sm font-medium text-white">Government Murray College, Sialkot</p>
                    <p class="text-xs text-slate-400">Academic Portal & Management System</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-800 py-6 text-center text-slate-500 text-sm">
        &copy; {{ date('Y') }} Murray College Management System. All rights reserved.
    </footer>

</body>
</html>