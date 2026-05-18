@extends('layouts.admin')

@php
    $title = 'New Page';
    $breadcrumb = 'Pages → Create';
@endphp

@section('content')

<div class="w-full">

    <a href="{{ route('pages.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Pages
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-base font-semibold text-slate-900">Create New Page</h2>
            <p class="text-sm text-slate-500 mt-0.5">A slug will be auto-generated from the title.</p>
        </div>

        <form method="POST" action="{{ route('pages.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Company (super_admin only) --}}
            @if(isset($companies) && $companies)
            <div>
                <label for="company_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Company <span class="text-red-500">*</span>
                </label>
                <select id="company_id" name="company_id"
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 bg-white">
                    <option value="">— Select Company —</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Page Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="e.g. Home"
                       class="w-full px-4 py-2.5 text-sm border rounded-xl outline-none transition-all
                              {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400' }}">
                @error('title')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Section --}}
            <div class="pt-2 border-t border-slate-100">
                <p class="text-sm font-medium text-slate-700 mb-4">SEO Settings</p>

                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm text-slate-600 mb-1.5">Meta Title</label>
                        <input type="text"
                               id="meta_title"
                               name="meta_title"
                               value="{{ old('meta_title') }}"
                               placeholder="Page title for search engines"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm text-slate-600 mb-1.5">Meta Description</label>
                        <textarea id="meta_description"
                                  name="meta_description"
                                  rows="3"
                                  placeholder="Short description for search engine results..."
                                  class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 resize-none">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Publish Toggle --}}
            <div class="flex items-center justify-between py-3 px-4 bg-slate-50 rounded-xl border border-slate-200">
                <div>
                    <p class="text-sm font-medium text-slate-700">Publish Page</p>
                    <p class="text-xs text-slate-500">Make this page publicly visible</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           id="is_published"
                           {{ old('is_published') ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-indigo-600
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                    Create Page
                </button>
                <a href="{{ route('pages.index') }}"
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection