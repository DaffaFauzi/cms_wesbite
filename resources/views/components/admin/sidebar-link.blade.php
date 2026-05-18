@props(['href', 'active' => false, 'tooltip' => ''])

<a href="{{ $href }}"
    class="group relative flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 overflow-hidden"
    :class="collapsed ? 'lg:justify-center' : ''">

    {{-- left active indicator --}}
    <div @class([
        'absolute left-0 top-0 bottom-0 w-1 rounded-r-md transition-all',
        'bg-indigo-500 shadow-[0_8px_30px_rgba(99,102,241,0.08)]' => $active,
    ])></div>

    <div @class([
        'flex-shrink-0 transition-colors',
        'text-indigo-300' => $active,
        'text-slate-400 group-hover:text-indigo-300' => ! $active,
    ])>
        {{ $icon ?? '' }}
    </div>

    <span class="flex-1 truncate transition-opacity duration-300"
          :class="collapsed ? 'lg:opacity-0 lg:hidden' : 'opacity-100'">
        <span @class([
            'text-indigo-100' => $active,
            'text-slate-200 group-hover:text-indigo-100' => ! $active,
        ])>{{ $slot }}</span>
    </span>

    {{-- Active glowing background --}}
    @if($active)
        <div class="pointer-events-none absolute inset-0 rounded-lg bg-indigo-600/6 blur-sm opacity-100"></div>
    @endif

    {{-- Custom Tooltip for collapsed state --}}
    @if($tooltip)
           <div x-show="collapsed" style="display: none;"
               class="hidden lg:block absolute left-full ml-4 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none whitespace-nowrap z-50 shadow-xl border border-white/10 -translate-x-2 group-hover:translate-x-0">
            {{ $tooltip }}
            <div class="absolute top-1/2 -left-1 -mt-1 w-2 h-2 bg-slate-800 border-l border-t border-white/10 transform -rotate-45"></div>
        </div>
    @endif
</a>
