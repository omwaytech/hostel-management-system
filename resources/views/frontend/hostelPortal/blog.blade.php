@extends('frontend.layouts.hostelPortal')
@section('body')
    <!-- Room Banner start -->
    <section class="bg-[#E5E4E2] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">News & Blogs</h1>

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
    <!-- Room Banner end -->
    <div class=" min-h-screen py-10 px-4">
        <div class="container mx-auto max-w-7xl">
            <!-- Blog Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card 1 -->
                @foreach ($newsAndBlogs as $blog)
                    <a href="{{ route('hostel.blogDetail', [$hostel->slug, $blog->slug]) }}" class="block">
                        <div
                            class="bg-white rounded-[8px] overflow-hidden shadow-custom-combo transition-shadow duration-300">
                            <!-- Image -->
                            <div class="relative overflow-hidden" style="padding-bottom: 75%;">
                                <img src="{{ asset('storage/images/newsBlogImages/' . $blog->nb_image) }}"
                                    alt="{{ $blog->nb_title }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <div class="mb-4">
                                    <span
                                        class="text-[#076166] bg-[#F1F4F4] rounded-full px-3 py-2 font-medium text-sm font-heading ">{{ $blog->nb_badge }}</span>
                                </div>

                                <!-- Title -->
                                <h2 class="text-xl font-heading font-bold text-color mb-2 overflow-hidden truncate">
                                    {{ $blog->nb_title }}
                                </h2>
                                <!-- Description -->
                                <p class="sub-text text-sm font-heading font-light mb-4 line-clamp-2">
                                    {!! !!!$blog->nb_description !!}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center font-heading font-regular sub-text text-xs mb-4 gap-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $blog->created_at->format('F d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $blog->nb_time_to_read }} min read</span>
                                    </div>
                                </div>

                                <!-- Author -->
                                <div class="flex items-center pt-4 border-t-[0.5px] border-[#E1DFDF]">
                                    <img src="{{ asset('storage/images/authorImages/' . $blog->nb_author_image) }}"
                                        alt="{{ $blog->nb_author_name }}" class="w-8 h-8 rounded-full mr-2">
                                    <span
                                        class="text-color font-heading font-regular text-sm">{{ $blog->nb_author_name }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        {{ $newsAndBlogs->links('pagination::hostelPortal') }}
    </div>
@endsection
