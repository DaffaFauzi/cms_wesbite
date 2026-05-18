@extends('layouts.admin')

@php
    $title = 'Companies';
    $breadcrumb = 'Manage all companies on this platform';
@endphp

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-900">All Companies</h2>
        <p class="text-sm text-slate-500">{{ $companies->total() }} total companies registered</p>
    </div>
    <a href="{{ route('companies.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Company
    </a>
</div>

{{-- Search --}}
<div class="bg-white rounded-2xl border border-slate-200 mb-6">
    <form method="GET" action="{{ route('companies.index') }}" class="flex gap-2 p-4">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search by name or slug..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-all">
        </div>
        <button type="submit"
                class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-colors">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('companies.index') }}"
               class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                Clear
            </a>
        @endif
    </form>
</div>

{{-- Company Cards Grid --}}
@if($companies->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200 py-16 px-8">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-700 mb-1">No companies found</h3>
        <p class="text-sm text-slate-400 mb-4">Get started by creating your first company.</p>
        <a href="{{ route('companies.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
            + Create Company
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
        @foreach($companies as $company)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-slate-300 hover:shadow-sm transition-all group">

                {{-- Color Swatch Header --}}
                <div class="h-2"
                     style="background: linear-gradient(to right, {{ $company->primary_color ?? '#4f46e5' }}, {{ $company->secondary_color ?? '#7c3aed' }})">
                </div>

                <div class="p-5">
                    {{-- Name & Slug --}}
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm leading-snug">{{ $company->name }}</h3>
                            <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $company->slug }}</p>
                        </div>
                        <a href="/site/{{ $company->slug }}"
                           target="_blank"
                           class="flex-shrink-0 p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                           title="View Site">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ $company->pages_count }} pages
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            {{ $company->users_count }} users
                        </div>
                        @if($company->font_family)
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"/>
                            </svg>
                            {{ $company->font_family }}
                        </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                        <a href="{{ route('companies.edit', $company) }}"
                           class="flex-1 text-center px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('companies.destroy', $company) }}"
                              method="POST"
                              onsubmit="return confirm('Delete {{ addslashes($company->name) }}? This cannot be undone.')">
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

    {{-- Pagination --}}
    @if($companies->hasPages())
        <div class="mt-6">
            {{ $companies->links() }}
        </div>
    @endif
@endif

@endsection
