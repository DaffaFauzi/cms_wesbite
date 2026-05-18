@extends('layouts.admin')

@php
    $title = 'Pages';
    $breadcrumb = 'Manage your website pages';
@endphp

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-900">All Pages</h2>
        <p class="text-sm text-slate-500">{{ $pages->total() }} pages found</p>
    </div>
    <a href="{{ route('pages.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Page
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl border border-slate-200 mb-6">
    <form method="GET" action="{{ route('pages.index') }}" class="flex flex-wrap gap-2 p-4">
        <div class="flex-1 min-w-48 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search pages..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-all">
        </div>
        <select name="status"
                class="px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none bg-white">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit"
                class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-colors">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('pages.index') }}"
               class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                Clear
            </a>
        @endif
    </form>
</div>

{{-- Pages Table --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

    @if($pages->isEmpty())
        <div class="py-16 px-8">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-slate-700 mb-1">No pages found</h3>
            <p class="text-sm text-slate-400 mb-4">Create your first page to get started.</p>
            <a href="{{ route('pages.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                + Create Page
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Title</th>
                        <th class="text-left px-4 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Slug</th>
                        @if(auth()->user()->role === 'super_admin')
                        <th class="text-left px-4 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Company</th>
                        @endif
                        <th class="text-left px-4 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Sections</th>
                        <th class="text-right px-6 py-3.5 font-medium text-slate-600 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pages as $page)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $page->title }}</div>
                                @if($page->meta_description)
                                    <div class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ $page->meta_description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <code class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-md">/{{ $page->slug }}</code>
                            </td>
                            @if(auth()->user()->role === 'super_admin')
                            <td class="px-4 py-4">
                                <span class="text-slate-600 text-xs">{{ $page->company->name ?? '—' }}</span>
                            </td>
                            @endif
                            <td class="px-4 py-4">
                                @if($page->is_published)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('pages.sections.index', $page) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    Manage
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('pages.edit', $page) }}"
                                       class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('pages.destroy', $page) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete \'{{ addslashes($page->title) }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pages->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    @endif

</div>

@endsection