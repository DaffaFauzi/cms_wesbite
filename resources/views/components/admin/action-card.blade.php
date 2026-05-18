@props(['href', 'title', 'iconColor' => 'indigo'])

@php
    $colors = [
        'indigo' => 'bg-indigo-50/50 text-indigo-600 group-hover:text-indigo-700 ring-indigo-500/20 group-hover:ring-indigo-500/30 group-hover:bg-indigo-50',
        'rose' => 'bg-rose-50/50 text-rose-600 group-hover:text-rose-700 ring-rose-500/20 group-hover:ring-rose-500/30 group-hover:bg-rose-50',
        'violet' => 'bg-violet-50/50 text-violet-600 group-hover:text-violet-700 ring-violet-500/20 group-hover:ring-violet-500/30 group-hover:bg-violet-50',
        'cyan' => 'bg-cyan-50/50 text-cyan-600 group-hover:text-cyan-700 ring-cyan-500/20 group-hover:ring-cyan-500/30 group-hover:bg-cyan-50',
    ];
    $colorClass = $colors[$iconColor] ?? $colors['indigo'];
@endphp

<a href="{{ $href }}" class="group flex items-center gap-3 px-3 py-2 rounded-xl border border-transparent hover:border-slate-700/10 hover:bg-slate-800/40 hover:shadow transition-all duration-200">
    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-white/6 ring-1 ring-black/5 transition-colors {{ $colorClass }}">
        <div class="w-4 h-4">
            {{ $icon ?? '' }}
        </div>
    </div>
    <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">{{ $title }}</span>
    <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-slate-400 group-hover:text-slate-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </div>
</a>
