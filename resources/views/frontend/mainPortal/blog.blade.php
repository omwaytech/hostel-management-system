@extends('frontend.layouts.mainPortal')

@section('body')
    <!-- Blog Banner start -->
    <section class="bg-[#e0e2e5] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">News & Blogs
            </h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">News & Blogs</span>
            </nav>
        </div>
    </section>
    <!-- Blog Banner end -->

    <!-- Blog Content Start -->
    <div class="bg-gray-50 py-16">
        <div class=" px-5 md:px-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-8xl">
                <!-- Card 1 - Management -->
                @foreach ($blogs as $blog)
                    <div class="bg-white rounded-[20px] box-shadow overflow-hidden">
                        <div class="h-64 overflow-hidden relative">
                            <img src="{{ asset('storage/images/blogImages/' . $blog->blog_image) }}"
                                alt="{{ $blog->blog_title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/35"></div>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('blogDetail', $blog->slug) }}">
                                <h3 class="text-xl font-bold text-color font-heading flex items-start justify-between">
                                    {{ $blog->blog_title }}
                                    <svg class="w-5 h-5 ml-2 shrink-0 mt-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 17L17 7M17 7H7M17 7v10" />
                                    </svg>
                                </h3>
                            </a>
                            <p class="text-sm font-heading text-body font-light mt-2.5">{!! Str::words($blog->blog_description, 10) !!}</p>
                            <div class="flex items-center mt-2.5 font-heading">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='50' fill='%2393c5fd'/%3E%3Ccircle cx='50' cy='40' r='15' fill='white'/%3E%3Cpath d='M 30 70 Q 50 55 70 70 L 70 100 L 30 100 Z' fill='white'/%3E%3C/svg%3E"
                                    alt="{{ $blog->blog_author_name }}" class="w-10 h-10 rounded-full">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-color">{{ $blog->blog_author_name }}</div>
                                    <div class="text-xs sub-text">
                                        {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $blogs->links('pagination::mainPortal') }}

    </div>
    <!-- Blog Content End -->
@endsection
