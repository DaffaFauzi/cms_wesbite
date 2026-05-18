<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-950">

    {{-- Background image --}}
    @if(!empty($content['bg_image']))
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('{{ $content['bg_image'] }}')"></div>
        <div class="absolute inset-0 bg-black/60"></div>
    @else
        <div class="absolute inset-0 bg-gradient-brand opacity-90"></div>
    @endif

    {{-- Decorative blobs --}}
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">

        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-white leading-tight mb-6">
            {{ $content['title'] ?? 'Welcome' }}
        </h1>

        @if(!empty($content['subtitle']))
            <p class="text-lg sm:text-xl lg:text-2xl text-white/80 mb-10 max-w-2xl mx-auto leading-relaxed">
                {{ $content['subtitle'] }}
            </p>
        @endif

        @if(!empty($content['cta_text']))
            <a href="{{ $content['cta_url'] ?? '#' }}"
               class="inline-flex items-center gap-2 bg-white text-gray-900 font-semibold px-8 py-4 rounded-2xl
                      hover:bg-opacity-90 transition-all shadow-2xl shadow-black/20 text-sm sm:text-base">
                {{ $content['cta_text'] }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        @endif

    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/50 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

</section>