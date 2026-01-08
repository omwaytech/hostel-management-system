@extends('frontend.layouts.hostelPortal')

@section('body')
    <section class="bg-[#E5E4E2] w-full h-[80px] flex items-center sticky top-[88px] z-9999">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Terms And Policy</h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('hostel.index', $hostel->slug) }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">{{ $term->tp_title ?? 'N/A' }}</span>
            </nav>
        </div>
    </section>

    <section class="mt-10">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px]">
            <div class="bg-white p-12 rounded-[8px] shadow-custom-combo">
                <!-- Section Title -->
                <h2 class="text-lg text-center font-medium text-subcolor font-heading tracking-tight">
                    <strong>{{ $term->tp_title ?? 'N/A' }}</strong>
                </h2>

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-10 mt-10">
                    <!-- Left Column -->
                    <div
                        class=" text-[#443838] text-sm sm:text-base font-heading font-regular text-justify
                tracking-tight">
                        <p class="leading-6">
                            {!! $term->tp_description ?? 'N/A' !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
