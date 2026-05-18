@props(['title', 'description', 'actionUrl' => null, 'actionText' => null])

<div class="px-6 py-10 text-left flex flex-col items-start justify-center bg-transparent">
    <div class="w-16 h-16 bg-slate-800 ring-1 ring-black/10 rounded-2xl flex items-center justify-center mb-4 text-slate-400 shadow-sm">
        @if(isset($icon))
            {{ $icon }}
        @else
            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        @endif
    </div>
    <h3 class="text-sm font-semibold text-slate-100">{{ $title }}</h3>
    <p class="text-xs text-slate-400 mt-2 max-w-sm">{{ $description }}</p>
    
    @if($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all shadow-sm ring-1 ring-inset ring-black/10 active:scale-95">
            {{ $actionText }}
        </a>
    @endif
</div>
