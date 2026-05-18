<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CMS Admin' }} — APG CMS</title>
    <!-- Inter font for modern UI -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900 h-full" style="font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;">

<div class="app-layout flex min-h-screen bg-slate-50" 
     x-data="{ 
        mobileOpen: false, 
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true' 
     }"
     x-init="$watch('collapsed', value => localStorage.setItem('sidebarCollapsed', value))">

    {{-- ========== MOBILE OVERLAY ========== --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 z-[60] bg-slate-900/50 lg:hidden"
         style="display:none"></div>

    {{-- ========== SIDEBAR ========== --}}
    <x-admin.sidebar />

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="main-content flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out">

        {{-- TOPBAR --}}
        <x-admin.topbar :title="$title ?? null">
            @isset($headerActions)
                <x-slot name="headerActions">
                    {{ $headerActions }}
                </x-slot>
            @endisset
        </x-admin.topbar>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 w-full px-6 pt-5 pb-12">
            <div class="space-y-6">
                
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm shadow-sm">
                        <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm shadow-sm">
                        <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
                
            </div>
        </main>

    </div>

</div>

{{-- Alpine.js for sidebar toggle --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>