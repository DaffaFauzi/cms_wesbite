@extends('layouts.admin')

@php
    $title = 'Edit Section';
    $breadcrumb = 'Pages → ' . $page->title . ' → Edit Section';

    $jsonTemplates = [
        'hero' => json_encode([
            'title'    => 'Welcome to Our Company',
            'subtitle' => 'We build amazing products.',
            'cta_text' => 'Get Started',
            'cta_url'  => '#contact',
            'bg_image' => '',
        ], JSON_PRETTY_PRINT),
        'about' => json_encode([
            'title' => 'About Us',
            'body'  => 'We are a passionate team dedicated to delivering excellence.',
            'image' => '',
        ], JSON_PRETTY_PRINT),
        'services' => json_encode([
            'title' => 'Our Services',
            'items' => [
                ['name' => 'Web Design',  'description' => 'Beautiful, responsive websites.', 'icon' => '🎨'],
                ['name' => 'Development', 'description' => 'Scalable web applications.',       'icon' => '💻'],
                ['name' => 'Consulting',  'description' => 'Expert digital strategy.',          'icon' => '🧠'],
            ],
        ], JSON_PRETTY_PRINT),
        'gallery' => json_encode([
            'title'  => 'Our Gallery',
            'images' => [
                ['url' => '', 'caption' => 'Image 1'],
                ['url' => '', 'caption' => 'Image 2'],
                ['url' => '', 'caption' => 'Image 3'],
            ],
        ], JSON_PRETTY_PRINT),
        'contact' => json_encode([
            'title'   => 'Contact Us',
            'email'   => 'hello@example.com',
            'phone'   => '+1 234 567 8900',
            'address' => '123 Main Street, City, Country',
        ], JSON_PRETTY_PRINT),
    ];
@endphp

@section('content')

<div class="w-full">

    <a href="{{ route('pages.sections.index', $page->id) }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Sections
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-base font-semibold text-slate-900">Edit Section</h2>
            <p class="text-sm text-slate-500 mt-0.5">Page: <span class="font-medium text-slate-700">{{ $page->title }}</span></p>
        </div>

        <form method="POST"
              action="{{ route('pages.sections.update', [$page->id, $section->id]) }}"
              class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Type --}}
            <div>
                <label for="type" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Section Type <span class="text-red-500">*</span>
                </label>
                <select id="type"
                        name="type"
                        onchange="onTypeChange(this.value)"
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 bg-white">
                    @foreach(['hero', 'about', 'services', 'gallery', 'contact'] as $t)
                        <option value="{{ $t }}"
                                {{ old('type', $section->type) === $t ? 'selected' : '' }}>
                            {{ ucfirst($t) }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Order --}}
            <div>
                <label for="order" class="block text-sm font-medium text-slate-700 mb-1.5">Display Order</label>
                <input type="number"
                       id="order"
                       name="order"
                       value="{{ old('order', $section->order) }}"
                       min="0"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                @error('order')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="content" class="block text-sm font-medium text-slate-700">
                        Content (JSON)
                    </label>
                    <div class="flex items-center gap-2">
                        <span id="json-status" class="text-xs font-medium hidden"></span>
                        <button type="button"
                                onclick="loadTemplate(document.getElementById('type').value)"
                                class="text-xs font-medium text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 px-2.5 py-1 rounded-lg transition-colors">
                            Reset to Template
                        </button>
                    </div>
                </div>
                <textarea id="content"
                          name="content"
                          rows="16"
                          oninput="validateJson(this)"
                          class="w-full px-4 py-3 text-sm border rounded-xl outline-none transition-all font-mono
                                 {{ $errors->has('content') ? 'border-red-400 bg-red-50' : 'border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400' }}">{{ old('content', $section->content ? json_encode($section->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                @error('content')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                    Save Changes
                </button>
                <a href="{{ route('pages.sections.index', $page->id) }}"
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                    Cancel
                </a>
                <form action="{{ route('pages.sections.destroy', [$page->id, $section->id]) }}"
                      method="POST"
                      class="ml-auto"
                      onsubmit="return confirm('Delete this section?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                        Delete
                    </button>
                </form>
            </div>

        </form>
    </div>
</div>

<script>
const templates = @json($jsonTemplates);

function loadTemplate(type) {
    const textarea = document.getElementById('content');
    if (templates[type]) {
        textarea.value = templates[type];
        validateJson(textarea);
    }
}

function onTypeChange(type) {
    // Warn before wiping existing content
    if (document.getElementById('content').value.trim()) {
        if (!confirm('Change type? You can click "Reset to Template" to load the new template.')) {
            return;
        }
    }
}

function validateJson(textarea) {
    const status = document.getElementById('json-status');
    try {
        if (textarea.value.trim()) {
            JSON.parse(textarea.value);
            status.textContent = '✓ Valid JSON';
            status.className = 'text-xs font-medium text-emerald-600';
            status.classList.remove('hidden');
            textarea.classList.remove('border-red-400', 'bg-red-50');
            textarea.classList.add('border-slate-200');
        } else {
            status.classList.add('hidden');
        }
    } catch (e) {
        status.textContent = '✗ Invalid JSON';
        status.className = 'text-xs font-medium text-red-600';
        status.classList.remove('hidden');
        textarea.classList.add('border-red-400', 'bg-red-50');
        textarea.classList.remove('border-slate-200');
    }
}

// Validate existing content on load
document.addEventListener('DOMContentLoaded', () => {
    validateJson(document.getElementById('content'));
});
</script>

@endsection