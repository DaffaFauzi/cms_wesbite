<section class="py-20 lg:py-32 bg-gray-50" id="contact">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">

            {{-- Contact Info --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-6">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Get In Touch
                </div>

                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">
                    {{ $content['title'] ?? 'Contact Us' }}
                </h2>

                <div class="w-16 h-1 bg-gradient-brand rounded-full mb-8"></div>

                <div class="space-y-5">

                    @if(!empty($content['email']))
                        <a href="mailto:{{ $content['email'] }}"
                           class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-primary/30 hover:shadow-md transition-all group">
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Email</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $content['email'] }}</p>
                            </div>
                        </a>
                    @endif

                    @if(!empty($content['phone']))
                        <a href="tel:{{ $content['phone'] }}"
                           class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-primary/30 hover:shadow-md transition-all group">
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-colors">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Phone</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $content['phone'] }}</p>
                            </div>
                        </a>
                    @endif

                    @if(!empty($content['address']))
                        <div class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Address</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $content['address'] }}</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Send a Message</h3>
                <form class="space-y-4" onsubmit="return false">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                            <input type="text"
                                   placeholder="Your name"
                                   class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email"
                                   placeholder="your@email.com"
                                   class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Subject</label>
                        <input type="text"
                               placeholder="How can we help?"
                               class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                        <textarea rows="4"
                                  placeholder="Tell us more..."
                                  class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full text-center">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
