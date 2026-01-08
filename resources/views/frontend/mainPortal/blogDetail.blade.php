@extends('frontend.layouts.mainPortal')

@section('body')
    <div class="container bg-white border border-[#E2E7E9] mx-auto px-4 md:px-8 lg:px-[120px] max-w-full">
        <!-- Back Button and Room Header -->
        <div class="mb-6 mt-6 text-sm">
            <a href="{{ route('blog') }}"
                class="inline-flex  items-center border rounded-sm gap-1 border-color px-4 py-2 hover:bg-[#023be4] hover:text-white hover-text-color mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
                </svg>
                Back to News & Blogs
            </a>
            <div class="flex items-start">
                <div class="space-y-2">
                    <h1 class="text-xl font-bold text-color">{{ $blogDetail->blog_title }}</h1>
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
                    <img src="{{ asset('storage/images/blogImages/' . $blogDetail->blog_image) }}"
                        alt="{{ $blogDetail->blog_title }}" class="w-full h-64 md:h-96 object-cover rounded-lg">
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap items-center gap-3 mb-4 text-sm sub-text">
                    <span
                        class="bg-[#023be4] text-white px-3 py-2 font-heading rounded-lg">{{ $blogDetail->blog_badge }}</span>
                    <!-- Date -->
                    <div
                        class="flex font-heading font-regular border-[#E1DFDF] border px-3 py-2 rounded-lg items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M17 14a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-4-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-6-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2" />
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M7 1.75a.75.75 0 0 1 .75.75v.763c.662-.013 1.391-.013 2.193-.013h4.113c.803 0 1.532 0 2.194.013V2.5a.75.75 0 0 1 1.5 0v.827q.39.03.739.076c1.172.158 2.121.49 2.87 1.238c.748.749 1.08 1.698 1.238 2.87c.153 1.14.153 2.595.153 4.433v2.112c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.945c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433v-2.112c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.749-.748 1.698-1.08 2.87-1.238q.35-.046.739-.076V2.5A.75.75 0 0 1 7 1.75M5.71 4.89c-1.005.135-1.585.389-2.008.812S3.025 6.705 2.89 7.71q-.034.255-.058.539h18.336q-.024-.284-.058-.54c-.135-1.005-.389-1.585-.812-2.008s-1.003-.677-2.009-.812c-1.027-.138-2.382-.14-4.289-.14h-4c-1.907 0-3.261.002-4.29.14M2.75 12c0-.854 0-1.597.013-2.25h18.474c.013.653.013 1.396.013 2.25v2c0 1.907-.002 3.262-.14 4.29c-.135 1.005-.389 1.585-.812 2.008s-1.003.677-2.009.812c-1.027.138-2.382.14-4.289.14h-4c-1.907 0-3.261-.002-4.29-.14c-1.005-.135-1.585-.389-2.008-.812s-.677-1.003-.812-2.009c-.138-1.027-.14-2.382-.14-4.289z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($blogDetail->created_at)->format('d M Y') }}</span>

                    </div>

                    <!-- Time/Duration -->
                    <div
                        class="flex font-heading font-regular border-[#E1DFDF] border px-3 py-2 rounded-lg items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="m12.6 11.503l3.891 3.891l-.848.849L11.4 12V6h1.2zM12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-1.2a8.8 8.8 0 1 0 0-17.6a8.8 8.8 0 0 0 0 17.6" />
                        </svg>
                        <span>{{ $blogDetail->blog_time_to_read }} min read</span>
                    </div>
                </div>

                <article class="mb-10">
                    <div class="text-body font-heading font-light text-base text-justify leading-relaxed mb-2">
                        {!! $blogDetail->blog_description !!}
                    </div>
                </article>

                <!-- Tags Footer -->
                @php
                    $tags = json_decode($blogDetail->meta_tags, true) ?? [];
                @endphp
                @if (!empty($tags))
                    <div class="flex flex-wrap gap-2 pt-6 border-t">
                        <span class="text-sm sub-text font-heading">Tags:</span>
                        @foreach ($tags as $tag)
                            <a href="#" class="text-xs">
                                <span
                                    class="border border-color text-color px-3 py-2 hover:bg-[#023be4] hover:text-white font-heading rounded">
                                    {{ $tag }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <div class="lg:sticky lg:top-32">
                    <!-- Recent News -->
                    <div class="bg-white rounded-lg border border-color p-6 mb-6">
                        <h3 class="text-xl font-bold text-color mb-4 font-heading">Recent News</h3>
                        <div class="space-y-4">
                            @foreach ($blogs as $blog)
                                @if ($blog->slug === $blogDetail->slug)
                                    @continue
                                @endif
                                <div class="flex gap-3 font-heading">
                                    <img src="{{ asset('storage/images/blogImages/' . $blog->blog_image) }}"
                                        alt="{{ $blog->blog_title }}" class="w-20 h-20 object-cover rounded">
                                    <div>
                                        <a href="{{ route('blogDetail', $blog->slug) }}"
                                            class="text-base font-regular text-color hover:text-[#7790c2]">{{ $blog->blog_title }}</a>
                                        <p class="text-[13px] sub-text mt-1 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M17 14a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-4-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-6-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2" />
                                                <path fill="currentColor" fill-rule="evenodd"
                                                    d="M7 1.75a.75.75 0 0 1 .75.75v.763c.662-.013 1.391-.013 2.193-.013h4.113c.803 0 1.532 0 2.194.013V2.5a.75.75 0 0 1 1.5 0v.827q.39.03.739.076c1.172.158 2.121.49 2.87 1.238c.748.749 1.08 1.698 1.238 2.87c.153 1.14.153 2.595.153 4.433v2.112c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.945c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433v-2.112c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.749-.748 1.698-1.08 2.87-1.238q.35-.046.739-.076V2.5A.75.75 0 0 1 7 1.75M5.71 4.89c-1.005.135-1.585.389-2.008.812S3.025 6.705 2.89 7.71q-.034.255-.058.539h18.336q-.024-.284-.058-.54c-.135-1.005-.389-1.585-.812-2.008s-1.003-.677-2.009-.812c-1.027-.138-2.382-.14-4.289-.14h-4c-1.907 0-3.261.002-4.29.14M2.75 12c0-.854 0-1.597.013-2.25h18.474c.013.653.013 1.396.013 2.25v2c0 1.907-.002 3.262-.14 4.29c-.135 1.005-.389 1.585-.812 2.008s-1.003.677-2.009.812c-1.027.138-2.382.14-4.289.14h-4c-1.907 0-3.261-.002-4.29-.14c-1.005-.135-1.585-.389-2.008-.812s-.677-1.003-.812-2.009c-.138-1.027-.14-2.382-.14-4.289z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($blogDetail->created_at)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
