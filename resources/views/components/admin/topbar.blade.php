<header class="bg-white/70 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-20 transition-all"
        style="backdrop-filter: blur(6px);">
    <div class="w-full px-6 md:px-8 xl:px-10 h-[72px] flex items-center justify-between gap-6">
        
        {{-- Left: Toggle & Breadcrumb --}}
        <div class="flex items-center gap-3">
            {{-- Mobile Menu --}}
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Desktop Collapse --}}
            <button @click="collapsed = !collapsed" class="hidden lg:flex p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-all active:scale-95">
                <svg class="w-5 h-5 transition-transform duration-300" :class="collapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>

            <div class="h-6 w-px bg-slate-200 mx-1 hidden lg:block"></div>

            <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500 font-medium ml-1">
                <span class="text-slate-400">Admin</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 font-semibold">{{ $title ?? 'Dashboard' }}</span>
            </div>
        </div>

        {{-- Center: Search (global) --}}
        <div class="flex-1 max-w-xl hidden md:block">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" placeholder="Search everything (⌘K)" class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all sm:text-sm shadow-sm">
                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                    <span class="text-[10px] text-slate-400 font-medium border border-slate-200 px-1.5 py-0.5 rounded bg-white">⌘K</span>
                </div>
            </div>
        </div>

        {{-- Right: Actions & User --}}
        <div class="flex items-center gap-3 lg:gap-4 flex-shrink-0">
            @isset($headerActions)
                <div class="hidden sm:flex items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endisset

            {{-- Notifications (visual) --}}
            <button class="p-2 rounded-full text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors relative" title="Notifications">
                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </button>

            {{-- Company Badge --}}
            @if(auth()->user()->role === 'admin' && auth()->user()->company)
                <div class="h-6 w-px bg-slate-200 mx-1 hidden sm:block"></div>
                <div class="flex items-center gap-2 hidden sm:flex">
                    <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs border border-indigo-100 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->company->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->company->name }}</span>
                </div>
            @endif

            {{-- Dark Mode Toggle --}}
            <button id="dark-toggle" class="ml-2 p-2 rounded-md bg-slate-50 hover:bg-slate-100 text-slate-600 hidden md:inline-flex" title="Toggle dark">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 0020.354 15.354z"/></svg>
            </button>
        </div>
    </div>
</header>

<script>
    // Simple dark toggle: toggles class on body
    (function(){
        const btn = document.getElementById('dark-toggle');
        if(!btn) return;
        btn.addEventListener('click', ()=>{
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('siteDark', document.documentElement.classList.contains('dark'));
        });
        if(localStorage.getItem('siteDark') === 'true') document.documentElement.classList.add('dark');
    })();
</script>
