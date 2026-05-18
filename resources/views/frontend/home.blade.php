<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?? $company->name }}</title>
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    {{-- Google Font based on company setting --}}
    @php
        $font = $company->font_family ?? 'Inter';
        $fontUrl = 'https://fonts.googleapis.com/css2?family=' . urlencode($font) . ':wght@300;400;500;600;700&display=swap';
        $primaryColor   = $company->primary_color   ?? '#4f46e5';
        $secondaryColor = $company->secondary_color ?? '#7c3aed';
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ $fontUrl }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Company Theme Variables --}}
    <style>
        :root {
            --color-primary:   {{ $primaryColor }};
            --color-secondary: {{ $secondaryColor }};
            --font-main:       '{{ $font }}', sans-serif;
        }
        body { font-family: var(--font-main); }
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: opacity 0.15s;
            display: inline-block;
        }
        .btn-primary:hover { opacity: 0.85; }
        .text-primary { color: var(--color-primary); }
        .bg-primary   { background-color: var(--color-primary); }
        .bg-gradient-brand {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

@forelse($sections as $section)

    @switch($section->type)

        @case('hero')
            @include('frontend.sections.hero', [
                'content' => is_array($section->content)
                    ? $section->content
                    : json_decode($section->content, true)
            ])
        @break

        @case('about')
            @include('frontend.sections.about', [
                'content' => is_array($section->content)
                    ? $section->content
                    : json_decode($section->content, true)
            ])
        @break

        @case('services')
            @include('frontend.sections.services', [
                'content' => is_array($section->content)
                    ? $section->content
                    : json_decode($section->content, true)
            ])
        @break

        @case('gallery')
            @include('frontend.sections.gallery', [
                'content' => is_array($section->content)
                    ? $section->content
                    : json_decode($section->content, true)
            ])
        @break

        @case('contact')
            @include('frontend.sections.contact', [
                'content' => is_array($section->content)
                    ? $section->content
                    : json_decode($section->content, true)
            ])
        @break

    @endswitch

@empty
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center px-6">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">{{ $company->name }}</h2>
            <p class="text-gray-400">No content published yet.</p>
        </div>
    </div>
@endforelse

</body>
</html>