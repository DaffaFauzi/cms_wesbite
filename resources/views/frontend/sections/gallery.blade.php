<section class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4">
                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                Gallery
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                {{ $content['title'] ?? 'Our Gallery' }}
            </h2>
        </div>

        {{-- Image Grid --}}
        @if(!empty($content['images']))
            @php $images = array_filter($content['images'], fn($i) => !empty($i['url'])); @endphp

            @if(count($images) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    @foreach($images as $image)
                        <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-gray-100 shadow-sm">
                            <img src="{{ $image['url'] }}"
                                 alt="{{ $image['caption'] ?? '' }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                            @if(!empty($image['caption']))
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent
                                            opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                    <p class="text-white text-sm font-medium px-4 pb-4">{{ $image['caption'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Placeholder grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @for($i = 0; $i < 6; $i++)
                        <div class="aspect-[4/3] bg-gradient-brand opacity-10 rounded-2xl animate-pulse"></div>
                    @endfor
                </div>
                <p class="text-center text-gray-400 text-sm mt-6">Add image URLs in the section content to display your gallery.</p>
            @endif
        @endif

    </div>
</section>
