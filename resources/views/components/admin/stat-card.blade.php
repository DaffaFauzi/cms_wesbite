@props(['title', 'value', 'subtitle' => null, 'iconColor' => 'indigo', 'trend' => null])

@php
    $colors = [
        'indigo' => 'bg-indigo-50/50 text-indigo-600 ring-indigo-500/20',
        'violet' => 'bg-violet-50/50 text-violet-600 ring-violet-500/20',
        'cyan' => 'bg-cyan-50/50 text-cyan-600 ring-cyan-500/20',
        'rose' => 'bg-rose-50/50 text-rose-600 ring-rose-500/20',
        'emerald' => 'bg-emerald-50/50 text-emerald-600 ring-emerald-500/20',
        'slate' => 'bg-slate-50/50 text-slate-600 ring-slate-500/20',
    ];
    $colorClass = $colors[$iconColor] ?? $colors['indigo'];
@endphp

<div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center ring-1 {{ $colorClass }} shadow-sm">
                <div class="w-5 h-5 {{ $colorClass }}">
                    {{ $icon ?? '' }}
                </div>
            </div>
            <h3 class="text-sm font-medium text-slate-600">{{ $title }}</h3>
        </div>
        
        @if($trend)
            <span class="inline-flex items-center gap-1 text-xs font-medium {{ str_starts_with($trend, '+') ? 'text-emerald-600' : 'text-rose-600' }}">
                @if(str_starts_with($trend, '+'))
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                @else
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                @endif
                {{ $trend }}
            </span>
        @endif
    </div>
    
    <div>
        <p class="text-3xl font-bold text-slate-900 tracking-tight">{{ $value }}</p>
        @if($subtitle)
            <p class="text-xs text-slate-500 mt-1 font-medium">{{ $subtitle }}</p>
        @endif
    </div>
</div>
