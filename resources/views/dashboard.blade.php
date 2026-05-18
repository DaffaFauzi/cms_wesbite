@extends('layouts.admin')

@php
    $title = 'Dashboard';
@endphp

@section('content')

<div class="space-y-8 lg:space-y-10">

    {{-- Dashboard Hero --}}
    <div class="bg-gradient-to-r from-indigo-50/60 to-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-slate-900 tracking-tight">Hello, {{ auth()->user()->name ?? 'User' }}</h1>
                <p class="text-sm text-slate-500 mt-1 max-w-xl">@if(auth()->user()->role === 'super_admin')Manage and monitor all companies and assets from here. @else Manage your company's content and settings quickly.@endif</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('companies.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold bg-white border border-slate-200 rounded-lg text-indigo-600 shadow-sm hover:shadow-md transition">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"/></svg>
                    Create Company
                </a>

                <a href="{{ route('pages.create') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Page
                </a>

                <a href="{{ route('media.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold bg-white border border-slate-200 rounded-lg text-rose-600 shadow-sm hover:shadow-md transition">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"/></svg>
                    Upload Asset
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

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

    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

        {{-- Recent Pages --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h2 class="text-sm font-semibold text-slate-900">Recent Pages</h2>
                    <a href="{{ route('pages.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">View all &rarr;</a>
                </div>

                <div class="flex-1 divide-y divide-slate-100/80">
                    @forelse($recentPages ?? [] as $page)
                        <div class="px-6 py-4 hover:bg-slate-50/50 transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
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

        {{-- Quick Actions --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-sm font-semibold text-slate-900">Quick Actions</h2>
                </div>

                <div class="p-4 grid gap-2">
                    <x-admin.action-card 
                        href="{{ route('pages.create') }}" 
                        title="Create New Page" 
                        iconColor="indigo">
                        <x-slot name="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></x-slot>
                    </x-admin.action-card>

                    <x-admin.action-card 
                        href="{{ route('media.index') }}" 
                        title="Upload Assets" 
                        iconColor="rose">
                        <x-slot name="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg></x-slot>
                    </x-admin.action-card>

                    @if(auth()->user()->role === 'super_admin')
                    <x-admin.action-card 
                        href="{{ route('companies.create') }}" 
                        title="Add Company" 
                        iconColor="violet">
                        <x-slot name="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg></x-slot>
                    </x-admin.action-card>
                    @endif

                    <x-admin.action-card 
                        href="{{ route('profile.edit') }}" 
                        title="Account Settings" 
                        iconColor="cyan">
                        <x-slot name="icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></x-slot>
                    </x-admin.action-card>
                </div>
            </div>

            @if(auth()->user()->role === 'admin' && auth()->user()->company)
            <div class="relative bg-slate-900 rounded-2xl overflow-hidden shadow-lg border border-slate-800">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="relative p-6">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white mb-4 ring-1 ring-white/20 shadow-inner">
                        {{ strtoupper(substr(auth()->user()->company->name, 0, 1)) }}
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Active Company</p>
                    <p class="text-lg font-bold text-white mb-5">{{ auth()->user()->company->name }}</p>
                    
                    <a href="/site/{{ auth()->user()->company->slug }}" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 text-xs font-semibold bg-white text-slate-900 rounded-lg hover:bg-slate-100 transition-colors shadow-sm">
                        View Live Site
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
            @endif
        </div>

    </div>

</div>

@endsection
