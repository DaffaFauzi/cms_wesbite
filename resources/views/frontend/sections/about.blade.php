<section class="py-20 lg:py-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Text --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-6">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    About Us
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    {{ $content['title'] ?? 'About Us' }}
                </h2>

                <div class="w-16 h-1 bg-gradient-brand rounded-full mb-6"></div>

                <p class="text-gray-600 text-lg leading-relaxed">
                    {{ $content['body'] ?? '' }}
                </p>
            </div>

            {{-- Image --}}
            <div class="relative">
                @if(!empty($content['image']))
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ $content['image'] }}"
                             alt="{{ $content['title'] ?? 'About' }}"
                             class="w-full h-80 lg:h-96 object-cover">
                    </div>
                    {{-- Decorative element --}}
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-gradient-brand rounded-2xl -z-10 opacity-30"></div>
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-2 border-primary/20 rounded-2xl -z-10"></div>
                @else
                    <div class="rounded-3xl bg-gradient-brand h-80 lg:h-96 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
