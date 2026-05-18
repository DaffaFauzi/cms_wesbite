@extends('layouts.admin')

@php
    $title = 'Edit Company';
    $breadcrumb = 'Companies → ' . $company->name;
@endphp

@section('content')

<div class="w-full">

    {{-- Back --}}
    <a href="{{ route('companies.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Companies
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Edit Company</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ $company->pages_count }} pages · {{ $company->users_count }} users
                </p>
            </div>
            <a href="/site/{{ $company->slug }}"
               target="_blank"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                View Site
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>

        <form method="POST"
              action="{{ route('companies.update', $company) }}"
              class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Company Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $company->name) }}"
                       class="w-full px-4 py-2.5 text-sm border rounded-xl outline-none transition-all
                              {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200' : 'border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400' }}">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">
                    URL Slug
                </label>
                <div class="flex rounded-xl overflow-hidden border {{ $errors->has('slug') ? 'border-red-400' : 'border-slate-200' }}">
                    <span class="px-3 py-2.5 bg-slate-50 text-slate-400 text-sm border-r border-slate-200 flex-shrink-0">
                        /site/
                    </span>
                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug', $company->slug) }}"
                           class="flex-1 px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 font-mono">
                </div>
                @error('slug')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Theme Section --}}
            <div class="pt-2 border-t border-slate-100">
                <p class="text-sm font-medium text-slate-700 mb-4">Theme Settings</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Primary Color --}}
                    <div>
                        <label for="primary_color" class="block text-sm text-slate-600 mb-1.5">Primary Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color"
                                   id="primary_color_picker"
                                   value="{{ old('primary_color', $company->primary_color ?? '#4f46e5') }}"
                                   class="w-10 h-10 rounded-lg border border-slate-200 cursor-pointer p-0.5"
                                   oninput="document.getElementById('primary_color').value = this.value; updatePreview()">
                            <input type="text"
                                   id="primary_color"
                                   name="primary_color"
                                   value="{{ old('primary_color', $company->primary_color ?? '#4f46e5') }}"
                                   class="flex-1 px-3 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 font-mono">
                        </div>
                    </div>

                    {{-- Secondary Color --}}
                    <div>
                        <label for="secondary_color" class="block text-sm text-slate-600 mb-1.5">Secondary Color</label>
                        <div class="flex gap-2 items-center">
                            <input type="color"
                                   id="secondary_color_picker"
                                   value="{{ old('secondary_color', $company->secondary_color ?? '#7c3aed') }}"
                                   class="w-10 h-10 rounded-lg border border-slate-200 cursor-pointer p-0.5"
                                   oninput="document.getElementById('secondary_color').value = this.value; updatePreview()">
                            <input type="text"
                                   id="secondary_color"
                                   name="secondary_color"
                                   value="{{ old('secondary_color', $company->secondary_color ?? '#7c3aed') }}"
                                   class="flex-1 px-3 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 font-mono">
                        </div>
                    </div>

                </div>

                {{-- Font Family --}}
                <div class="mt-4">
                    <label for="font_family" class="block text-sm text-slate-600 mb-1.5">Font Family</label>
                    <select id="font_family"
                            name="font_family"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                        @foreach(['Inter', 'Poppins', 'Roboto', 'Lato', 'Montserrat', 'Nunito', 'Raleway', 'Open Sans'] as $font)
                            <option value="{{ $font }}"
                                    {{ old('font_family', $company->font_family) === $font ? 'selected' : '' }}>
                                {{ $font }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Theme Preview --}}
            <div id="theme-preview"
                 class="rounded-xl p-4 flex items-center gap-3 transition-all"
                 style="background: linear-gradient(135deg, {{ $company->primary_color ?? '#4f46e5' }}, {{ $company->secondary_color ?? '#7c3aed' }})">
                <div class="w-8 h-8 bg-white/20 rounded-lg"></div>
                <div>
                    <p class="text-white text-sm font-semibold" id="preview-name">{{ $company->name }}</p>
                    <p class="text-white/70 text-xs" id="preview-slug">/site/{{ $company->slug }}</p>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                    Save Changes
                </button>
                <a href="{{ route('companies.index') }}"
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                    Cancel
                </a>

                {{-- Danger Zone --}}
                <form action="{{ route('companies.destroy', $company) }}"
                      method="POST"
                      class="ml-auto"
                      onsubmit="return confirm('Permanently delete {{ addslashes($company->name) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                        Delete Company
                    </button>
                </form>
            </div>

        </form>
    </div>
</div>

<script>
function updatePreview() {
    const name      = document.getElementById('name').value || 'Company Name';
    const slug      = document.getElementById('slug').value || 'company-slug';
    const primary   = document.getElementById('primary_color').value || '#4f46e5';
    const secondary = document.getElementById('secondary_color').value || '#7c3aed';

    document.getElementById('preview-name').textContent = name;
    document.getElementById('preview-slug').textContent = '/site/' + slug;
    document.getElementById('theme-preview').style.background =
        `linear-gradient(135deg, ${primary}, ${secondary})`;
}

document.getElementById('primary_color').addEventListener('input', updatePreview);
document.getElementById('secondary_color').addEventListener('input', updatePreview);
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('slug').addEventListener('input', updatePreview);
</script>

@endsection
