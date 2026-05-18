<aside class="sidebar fixed inset-y-0 left-0 z-[70] flex flex-col bg-white border-r border-slate-200 transition-all duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen"
       :class="[
           mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
           collapsed ? 'lg:w-[88px]' : 'lg:w-[260px]',
           'w-[260px]'
       ]">
    
    {{-- Company Switcher / Brand --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100 transition-all duration-300"
         :class="collapsed ? 'lg:justify-center lg:px-3' : ''">
        <div class="w-9 h-9 bg-gradient-to-tr from-indigo-600 to-sky-400 rounded-xl flex items-center justify-center shadow-sm ring-1 ring-slate-100 shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 6-2-7L0 9h7z"/>
            </svg>
        </div>
        <div x-show="!collapsed" class="transition-opacity duration-300 overflow-hidden whitespace-nowrap">
            <p class="text-slate-900 font-semibold text-sm tracking-tight leading-none">APG CMS</p>
            <p class="text-slate-500 text-xs mt-0.5">Multi-Company</p>
        </div>
    </div>

    {{-- Company switcher quick select --}}
    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/80" x-show="!collapsed">
        <div class="flex items-center gap-2">
            <select class="w-full text-sm bg-white border border-slate-200 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                @foreach(auth()->user()->companies ?? [] as $c)
                    <option value="{{ $c->id }}" @if(auth()->user()->company && auth()->user()->company->id === $c->id) selected @endif>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-5 space-y-1 overflow-y-auto overflow-x-hidden"
         :class="collapsed ? 'lg:px-2 px-3' : 'px-3'">
        
        <div x-show="!collapsed" class="px-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-2">General</div>
        <x-admin.sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" tooltip="Overview">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </x-slot>
            Overview
        </x-admin.sidebar-link>

        <div x-show="!collapsed" class="px-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Content</div>

        <x-admin.sidebar-link href="{{ route('pages.index') }}" :active="request()->routeIs('pages.*') && !request()->routeIs('pages.sections.*')" tooltip="Pages">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot>
            Pages
        </x-admin.sidebar-link>

        <x-admin.sidebar-link href="{{ route('pages.index') }}" :active="request()->routeIs('pages.sections.*')" tooltip="Sections">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            </x-slot>
            Sections
        </x-admin.sidebar-link>

        <x-admin.sidebar-link href="{{ route('media.index') }}" :active="request()->routeIs('media.*')" tooltip="Assets">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </x-slot>
            Assets
        </x-admin.sidebar-link>

        @if(auth()->user()->role === 'super_admin')
            <div x-show="!collapsed" class="px-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Administration</div>
            <x-admin.sidebar-link href="{{ route('companies.index') }}" :active="request()->routeIs('companies.*')" tooltip="Companies">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </x-slot>
                Companies
            </x-admin.sidebar-link>
        @endif
    </nav>

    {{-- User / Footer Section --}}
    <div class="mt-auto border-t border-slate-100 bg-white/50 transition-all duration-300 p-4">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm font-semibold ring-1 ring-slate-100">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
                <div class="hidden lg:flex flex-col">
                    <p class="text-slate-900 text-sm font-medium truncate">{{ auth()->user()->name ?? 'Guest' }}</p>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider mt-0.5">{{ auth()->user()->role ?? 'user' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click="collapsed = !collapsed" class="p-2 text-slate-600 hover:bg-slate-100 rounded-md transition-colors hidden lg:inline-flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-600 hover:text-rose-500 rounded-md hover:bg-rose-50 transition-colors" title="Sign Out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
