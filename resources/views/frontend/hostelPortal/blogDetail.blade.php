@extends('frontend.layouts.hostelPortal')
@section('body')
    <div class="container bg-white border border-[#E2E7E9] mx-auto px-4 md:px-8 lg:px-[120px] max-w-full">
        <!-- Back Button and Room Header -->
        <div class="mb-6 mt-6 text-sm">
            <a href="{{ route('hostel.blog', $hostel->slug) }}"
                class="inline-flex  items-center border rounded-[4px] gap-1 border-[#E1DFDF] px-4 py-2 hover-bg-color hover:text-white hover-text-color mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
                </svg>
                Back to News & Blogs
            </a>
            <div class="flex items-start">
                <div class="space-y-2">
                    <h1 class="text-xl font-bold text-color">{{ $blog->nb_title }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class=" flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1 lg:w-2/3">
                <!-- Hero Image -->
                <div class="mb-6">
                    <img src="{{ asset('storage/images/newsBlogImages/' . $blog->nb_image) }}" alt="{{ $blog->nb_title }}"
                        class="w-full h-64 md:h-96 object-cover rounded-[8px]">
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap items-center gap-3 mb-4 text-sm sub-text">
                    <span class="bg-[#00a1a5] text-white px-3 py-2 font-heading rounded-[8px]">{{ $blog->nb_badge }}</span>
                    <!-- Date -->
                    <div
                        class="flex font-heading font-regular border-[#E1DFDF] border px-3 py-2 rounded-[8px] items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M17 14a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-4-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-6-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2" />
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M7 1.75a.75.75 0 0 1 .75.75v.763c.662-.013 1.391-.013 2.193-.013h4.113c.803 0 1.532 0 2.194.013V2.5a.75.75 0 0 1 1.5 0v.827q.39.03.739.076c1.172.158 2.121.49 2.87 1.238c.748.749 1.08 1.698 1.238 2.87c.153 1.14.153 2.595.153 4.433v2.112c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.945c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433v-2.112c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.749-.748 1.698-1.08 2.87-1.238q.35-.046.739-.076V2.5A.75.75 0 0 1 7 1.75M5.71 4.89c-1.005.135-1.585.389-2.008.812S3.025 6.705 2.89 7.71q-.034.255-.058.539h18.336q-.024-.284-.058-.54c-.135-1.005-.389-1.585-.812-2.008s-1.003-.677-2.009-.812c-1.027-.138-2.382-.14-4.289-.14h-4c-1.907 0-3.261.002-4.29.14M2.75 12c0-.854 0-1.597.013-2.25h18.474c.013.653.013 1.396.013 2.25v2c0 1.907-.002 3.262-.14 4.29c-.135 1.005-.389 1.585-.812 2.008s-1.003.677-2.009.812c-1.027.138-2.382.14-4.289.14h-4c-1.907 0-3.261-.002-4.29-.14c-1.005-.135-1.585-.389-2.008-.812s-.677-1.003-.812-2.009c-.138-1.027-.14-2.382-.14-4.289z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ $blog->created_at->format('F d, Y') }}</span>
                    </div>

                    <!-- Time/Duration -->
                    <div
                        class="flex font-heading font-regular border-[#E1DFDF] border px-3 py-2 rounded-[8px] items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="m12.6 11.503l3.891 3.891l-.848.849L11.4 12V6h1.2zM12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-1.2a8.8 8.8 0 1 0 0-17.6a8.8 8.8 0 0 0 0 17.6" />
                        </svg>
                        <span>{{ $blog->nb_time_to_read }} min read</span>
                    </div>
                </div>

                <!-- Article Content -->
                <article class="mb-10">
                    <div class="text-body font-heading font-light text-base text-justify leading-relaxed prose max-w-none">
                        {!! $blog->nb_description !!}
                    </div>
                </article>

                <!-- Tags Footer -->
                <div class="flex flex-wrap gap-2 pt-6 border-t">
                    <span class="text-sm sub-text font-heading">Tags:</span>
                    <a href="#" class="text-xs">
                        <span
                            class=" border border-[#E1DFDF] text-color px-3 py-2 hover-bg-color hover:text-white font-heading rounded">Hostel
                            Life</span>
                    </a>
                    <a href="#" class="text-xs">
                        <span
                            class=" border border-[#E1DFDF] text-color px-3 py-2 hover-bg-color hover:text-white
                        font-heading rounded">Student
                            Life</span>
                    </a>
                    <a href="#" class="text-xs">
                        <span
                            class=" border border-[#E1DFDF] text-color px-3 py-2 hover-bg-color hover:text-white
                        font-heading rounded">Life
                            Style</span>
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <div class="lg:sticky lg:top-32">
                    <!-- Recent News -->
                    <div class="bg-white rounded-[8px] border border-[#E1DFDF] p-6 mb-6">
                        <h3 class="text-xl font-bold text-color mb-4 font-heading">Recent News</h3>
                        <div class="space-y-4">
                            @forelse($recentNews as $news)
                                <!-- News Item -->
                                <div class="flex gap-3 font-heading">
                                    <img src="{{ asset('storage/images/newsBlogImages/' . $news->nb_image) }}"
                                        alt="{{ $news->nb_title }}" class="w-20 h-20 object-cover rounded">
                                    <div>
                                        <a href="{{ route('hostel.blogDetail', [$hostel->slug, $news->slug]) }}"
                                            class="text-base font-regular text-color hover:text-[#00A1A5] line-clamp-2">
                                            {{ $news->nb_title }}
                                        </a>
                                        <p class="text-[13px] sub-text mt-1 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M17 14a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-4-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-6-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2" />
                                                <path fill="currentColor" fill-rule="evenodd"
                                                    d="M7 1.75a.75.75 0 0 1 .75.75v.763c.662-.013 1.391-.013 2.193-.013h4.113c.803 0 1.532 0 2.194.013V2.5a.75.75 0 0 1 1.5 0v.827q.39.03.739.076c1.172.158 2.121.49 2.87 1.238c.748.749 1.08 1.698 1.238 2.87c.153 1.14.153 2.595.153 4.433v2.112c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.945c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433v-2.112c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.749-.748 1.698-1.08 2.87-1.238q.35-.046.739-.076V2.5A.75.75 0 0 1 7 1.75M5.71 4.89c-1.005.135-1.585.389-2.008.812S3.025 6.705 2.89 7.71q-.034.255-.058.539h18.336q-.024-.284-.058-.54c-.135-1.005-.389-1.585-.812-2.008s-1.003-.677-2.009-.812c-1.027-.138-2.382-.14-4.289-.14h-4c-1.907 0-3.261.002-4.29.14M2.75 12c0-.854 0-1.597.013-2.25h18.474c.013.653.013 1.396.013 2.25v2c0 1.907-.002 3.262-.14 4.29c-.135 1.005-.389 1.585-.812 2.008s-1.003.677-2.009.812c-1.027.138-2.382.14-4.289.14h-4c-1.907 0-3.261-.002-4.29-.14c-1.005-.135-1.585-.389-2.008-.812s-.677-1.003-.812-2.009c-.138-1.027-.14-2.382-.14-4.289z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $news->created_at->format('d-M-Y') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 font-heading">No recent news available.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Still Have Questions -->
                    <div class="bg-white rounded-[8px] p-6 border border-[#E1DFDF] justify-center text-center">
                        <span class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-4" width="40" height="40"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-7 12h-2v-2h2zm1.8-5c-.3.4-.7.6-1.1.8c-.3.2-.4.3-.5.5c-.2.2-.2.4-.2.7h-2c0-.5.1-.8.3-1.1c.2-.2.6-.5 1.1-.8c.3-.1.5-.3.6-.5s.2-.5.2-.7c0-.3-.1-.5-.3-.7s-.5-.3-.8-.3s-.5.1-.7.2q-.3.15-.3.6h-2c.1-.7.4-1.3.9-1.7s1.2-.5 2.1-.5s1.7.2 2.2.6s.8 1 .8 1.7q.15.6-.3 1.2" />
                            </svg>
                            <h3 class="text-xl font-bold text-color mb-4 font-heading">Still Have Questions?</h3>
                        </span>

                        <p class="text-body text-sm font-regular mb-4 font-heading">Our friendly team is here to help
                            you
                            with any
                            questions
                            or concerns you might have.</p>
                        <div class="flex justify-center">
                            <a href="{{ route('hostel.contact', $hostel->slug) }}"
                                class="w-[150px] bg-[#00A1A5] hover:bg-[#076166] font-heading text-base text-white font-bold py-3 px-6 rounded-full transition-colors duration-200 text-center">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
