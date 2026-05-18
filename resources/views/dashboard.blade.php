@extends('layouts.admin')

@php
    $title = 'Dashboard';
@endphp

@section('content')

<div class="space-y-8 lg:space-y-10">

    {{-- Dashboard Hero --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-950">Hello, {{ auth()->user()->name ?? 'User' }}</h1>
                <p class="mt-2 text-sm text-slate-500">@if(auth()->user()->role === 'super_admin')Manage and monitor all companies and assets from here. @else Manage your company's content and settings quickly.@endif</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('companies.create') }}" class="inline-flex h-11 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50">
                    Create Company
                </a>
                <a href="{{ route('pages.create') }}" class="inline-flex h-11 items-center gap-2 rounded-xl bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                    Add Page
                </a>
                <a href="{{ route('media.index') }}" class="inline-flex h-11 items-center gap-2 rounded-xl border border-rose-200 bg-white px-4 text-sm font-semibold text-rose-600 shadow-sm hover:bg-rose-50">
                    Upload Asset
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Grid --}}
    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

        @if(auth()->user()->role === 'super_admin')
        <x-admin.stat-card 
            title="Total Companies" 
            value="{{ $stats['companies'] ?? 0 }}" 
            iconColor="indigo"
            trend="+12%">
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </x-slot>
        </x-admin.stat-card>
        @endif

        <x-admin.stat-card 
            title="Total Pages" 
            value="{{ $stats['pages'] ?? 0 }}" 
            iconColor="violet"
            trend="+4%">
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot>
        </x-admin.stat-card>

        <x-admin.stat-card 
            title="Page Sections" 
            value="{{ $stats['sections'] ?? 0 }}" 
            iconColor="cyan">
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            </x-slot>
        </x-admin.stat-card>

        <x-admin.stat-card 
            title="Media Assets" 
            value="{{ $stats['media'] ?? 0 }}" 
            iconColor="rose">
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </x-slot>
        </x-admin.stat-card>

    </section>

    {{-- Content Grid --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-12">

        <div class="xl:col-span-8 rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-900">Recent Pages</h2>
                <a href="{{ route('pages.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">View all &rarr;</a>
            </div>

            <div class="p-6">
                <div class="space-y-3">
                    @forelse($recentPages ?? [] as $page)
                        <div class="flex items-center justify-between px-2 py-3 hover:bg-slate-50 rounded-md">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $page->title }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $page->company->name ?? '—' }} <span class="text-slate-300 mx-1">•</span> /{{ $page->slug }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($page->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-700 rounded-md ring-1 ring-inset ring-emerald-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 text-[10px] font-semibold bg-slate-100 text-slate-600 rounded-md ring-1 ring-inset ring-slate-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <x-admin.empty-state 
                            title="No pages found" 
                            description="Get started by creating your first page. Pages form the foundation of your website's content."
                            actionUrl="{{ route('pages.create') }}"
                            actionText="Create Page">
                            <x-slot name="icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                            </x-slot>
                        </x-admin.empty-state>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="xl:col-span-4 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
            {{-- Quick Actions --}}
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Quick Actions</h3>
            <div class="flex flex-col gap-3">
                <x-admin.action-card href="{{ route('pages.create') }}" title="Create New Page" iconColor="indigo" />
                <x-admin.action-card href="{{ route('media.index') }}" title="Upload Assets" iconColor="rose" />
                @if(auth()->user()->role === 'super_admin')
                    <x-admin.action-card href="{{ route('companies.create') }}" title="Add Company" iconColor="violet" />
                @endif
                <x-admin.action-card href="{{ route('profile.edit') }}" title="Account Settings" iconColor="cyan" />
            </div>
        </div>

    </section>

</div>

@endsection
