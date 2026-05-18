@props(['title', 'value', 'subtitle' => null, 'iconColor' => 'indigo', 'trend' => null])
@php
    $colors = [
        'indigo' => 'border-indigo-500 bg-indigo-50/5 text-indigo-400',
        'violet' => 'border-violet-500 bg-violet-50/5 text-violet-400',
        'cyan' => 'border-cyan-500 bg-cyan-50/5 text-cyan-400',
        'rose' => 'border-rose-500 bg-rose-50/5 text-rose-400',
        'emerald' => 'border-emerald-500 bg-emerald-50/5 text-emerald-400',
        'slate' => 'border-slate-500 bg-slate-50/5 text-slate-400',
    ];
    $colorClass = $colors[$iconColor] ?? $colors['indigo'];
@endphp

<div class="bg-white rounded-3xl border p-6 shadow-sm hover:shadow-lg transition-all duration-250 group overflow-hidden min-h-[150px]">
    <div class="h-1 -mx-6 rounded-t-3xl {{ explode(' ', $colorClass)[0] }}"></div>

    <div class="p-4">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center ring-1 ring-black/5 {{ explode(' ', $colorClass)[1] }} shadow-sm">
                    <div class="w-5 h-5 {{ explode(' ', $colorClass)[2] ?? '' }}">
                        {{ $icon ?? '' }}
                    </div>
                </div>
                <h3 class="text-sm font-medium text-slate-600">{{ $title }}</h3>
            </div>

            @if($trend)
                <span class="inline-flex items-center gap-1 text-xs font-semibold {{ str_starts_with($trend, '+') ? 'text-emerald-600' : 'text-rose-600' }}">
                    <span class="text-[11px] font-medium">{{ $trend }}</span>
                </span>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <p class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ $value }}</p>
            <div class="flex-1">
                {{-- sparkline placeholder --}}
                <svg class="w-full h-6 text-slate-300" viewBox="0 0 32 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 4L6 2L12 3L18 1L24 2L30 0L32 1" stroke="currentColor" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" class="opacity-40"/>
                </svg>
            </div>
        </div>

        @if($subtitle)
            <p class="text-xs text-slate-500 mt-2 font-medium">{{ $subtitle }}</p>
        @endif
    </div>
</div>
