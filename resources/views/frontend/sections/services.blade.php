<section class="py-20 lg:py-32 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4">
                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                What We Do
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                {{ $content['title'] ?? 'Our Services' }}
            </h2>
            <div class="w-16 h-1 bg-gradient-brand rounded-full mx-auto"></div>
        </div>

        {{-- Cards --}}
        @if(!empty($content['items']))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($content['items'] as $item)
                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">

                        {{-- Icon / Emoji --}}
                        @if(!empty($item['icon']))
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:bg-primary/20 transition-colors">
                                {{ $item['icon'] }}
                            </div>
                        @else
                            <div class="w-14 h-14 bg-gradient-brand rounded-2xl flex items-center justify-center mb-5">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        @endif

                        <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                            {{ $item['name'] ?? '' }}
                        </h3>

                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $item['description'] ?? '' }}
                        </p>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
