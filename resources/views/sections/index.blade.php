@extends('layouts.admin')

@php
    $title = 'Sections — ' . $page->title;
    $breadcrumb = 'Pages → ' . $page->title . ' → Sections';
@endphp

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('pages.index') }}"
           class="p-2 rounded-xl text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-semibold text-slate-900">{{ $page->title }}</h2>
            <p class="text-sm text-slate-500">{{ $sections->count() }} sections · <code class="font-mono">/{{ $page->slug }}</code></p>
        </div>
    </div>
    <a href="{{ route('pages.sections.create', $page->id) }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Section
    </a>
</div>

{{-- Sections --}}
@if($sections->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200 py-16 px-8">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-700 mb-1">No sections yet</h3>
        <p class="text-sm text-slate-400 mb-4">Add your first section to build this page.</p>
        <a href="{{ route('pages.sections.create', $page->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
            + Add Section
        </a>
    </div>
@else

@php
    $typeColors = [
        'hero'     => 'bg-violet-100 text-violet-700',
        'about'    => 'bg-sky-100 text-sky-700',
        'services' => 'bg-amber-100 text-amber-700',
        'gallery'  => 'bg-emerald-100 text-emerald-700',
        'contact'  => 'bg-rose-100 text-rose-700',
    ];
@endphp

    <div class="space-y-3">
        @foreach($sections as $section)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-slate-300 hover:shadow-sm transition-all">

                <div class="flex items-start gap-4 p-5">

                    {{-- Order Badge --}}
                    <div class="flex-shrink-0 w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 text-sm font-bold">
                        {{ $section->order }}
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide
                                         {{ $typeColors[$section->type] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $section->type }}
                            </span>
                            <span class="text-xs text-slate-400">
                                Updated {{ $section->updated_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Content Preview --}}
                        @if($section->content)
                            <div class="relative">
                                <pre id="content-{{ $section->id }}"
                                     class="text-xs bg-slate-50 border border-slate-100 text-slate-600 p-3 rounded-xl overflow-hidden max-h-24 transition-all">{{ json_encode($section->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                <button onclick="toggleContent('{{ $section->id }}')"
                                        class="absolute bottom-2 right-2 text-xs text-indigo-600 hover:text-indigo-800 bg-white px-2 py-0.5 rounded border border-slate-200 shadow-sm">
                                    Expand
                                </button>
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic">No content set</p>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                        <a href="{{ route('pages.sections.edit', [$page->id, $section->id]) }}"
                           class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('pages.sections.destroy', [$page->id, $section->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this {{ $section->type }} section?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <script>
    function toggleContent(id) {
        const el  = document.getElementById('content-' + id);
        const btn = el.nextElementSibling;
        if (el.classList.contains('max-h-24')) {
            el.classList.remove('max-h-24');
            btn.textContent = 'Collapse';
        } else {
            el.classList.add('max-h-24');
            btn.textContent = 'Expand';
        }
    }
    </script>

@endif

@endsection