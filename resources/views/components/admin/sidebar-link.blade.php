@props(['href', 'active' => false, 'tooltip' => ''])

<a href="{{ $href }}"
    class="group relative flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
             {{ $active
                  ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100'
                  : 'text-slate-700 hover:text-indigo-700 hover:bg-slate-50' }}"
    :class="collapsed ? 'lg:justify-center' : ''">
    
    <div class="flex-shrink-0 transition-colors {{ $active ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }}">
        {{ $icon ?? '' }}
    </div>
    
    <span class="flex-1 truncate transition-opacity duration-300"
          :class="collapsed ? 'lg:opacity-0 lg:hidden' : 'opacity-100'">
        {{ $slot }}
    </span>
    
    {{-- Custom Tooltip for collapsed state --}}
    @if($tooltip)
           <div x-show="collapsed" style="display: none;"
               class="hidden lg:block absolute left-full ml-4 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none whitespace-nowrap z-50 shadow-xl border border-white/10 -translate-x-2 group-hover:translate-x-0">
            {{ $tooltip }}
            <div class="absolute top-1/2 -left-1 -mt-1 w-2 h-2 bg-slate-800 border-l border-t border-white/10 transform -rotate-45"></div>
        </div>
    @endif
</a>
