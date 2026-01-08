@extends('frontend.layouts.hostelPortal')
@section('body')
    <!-- Room Banner start -->
    <section class="bg-[#E5E4E2] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-xl font-bold text-color mb-2 sm:mb-0 font-heading">
                @if ($room->occupancy)
                    {{ $room->occupancy->occupancy_type }}
                @else
                    Room {{ $room->room_number }}
                @endif
            </h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('hostel.room', $hostel->slug) }}" class="hover:underline font-heading">Rooms</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">Room-details</span>
            </nav>
        </div>
    </section>
    <!-- Room Banner end -->

    <!-- Room Detail Content -->
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Section with Images and Details -->
            <div class="lg:w-2/3">
                <!-- Image Slider -->
                <div class="relative mb-8 rounded-lg overflow-hidden group">
                    <!-- Main Slider -->
                    <div class="swiper mainSwiper group">
                        <div class="swiper-wrapper">
                            @if ($room->photo)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/roomPhotos/' . $room->photo) }}"
                                        alt="Room {{ $room->room_number }}" class="w-full h-[400px] object-cover">
                                </div>
                            @else
                                <div class="swiper-slide">
                                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800"
                                        alt="Room {{ $room->room_number }}" class="w-full h-[400px] object-cover">
                                </div>
                            @endif
                        </div>
                        <!-- Navigation Buttons -->
                        <div
                            class="swiper-button-prev !w-9 !h-9 md:!w-9 md:!h-9 bg-white rounded-full shadow-custom-combo border border-[#E1DFDF] !left-4 md:!left-6 after:!content-none flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-color" width="16" height="16"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="0.8" d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                            </svg>
                        </div>
                        <div
                            class="swiper-button-next !w-9 !h-9 md:!w-9 md:!h-9 bg-white rounded-full shadow-custom-combo border-[#E1DFDF] !right-4 md:!right-6 after:!content-none flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-color width=" 16" height="16"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="0.8" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                            </svg>
                        </div>
                    </div>

                    <!-- Thumbnail Slider -->
                    <div class="swiper thumbSwiper mt-4">
                        <div class="swiper-wrapper">
                            @if ($room->photo)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/roomPhotos/' . $room->photo) }}"
                                        alt="Thumbnail {{ $room->room_number }}"
                                        class="w-full h-16 sm:h-20 object-cover cursor-pointer opacity-70 hover:opacity-100 transition-opacity duration-200">
                                </div>
                            @else
                                <div class="swiper-slide">
                                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=200"
                                        alt="Thumbnail"
                                        class="w-full h-16 sm:h-20 object-cover cursor-pointer opacity-70 hover:opacity-100 transition-opacity duration-200">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Room Features -->
                <div class="mt-10 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-2xl leading-tight font-bold text-color">Room {{ $room->room_number }}</h1>
                        <div class="flex items-center gap-3">
                            @php
                                $availableBeds = $room->beds->where('status', 'Available')->count();
                            @endphp
                            @if ($availableBeds > 0)
                                <span
                                    class="inline-flex items-center px-4 py-1 text-xs font-medium font-heading text-white bg-[#21C45D] rounded-full">Available</span>
                            @else
                                <span
                                    class="inline-flex items-center px-4 py-1 text-xs font-medium font-heading text-white bg-red-500 rounded-full">Occupied</span>
                            @endif
                            @if ($room->floor && $room->floor->block)
                                <span
                                    class="inline-flex items-center px-4 py-1 text-xs font-medium font-heading text-color bg-[#F3F4F6] rounded-full">
                                    {{ $room->floor->block->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[#FBBF24]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        </span>
                        <span class="font-semibold font-heading text-[#444444]">4.5/5</span>
                        <span class="sub-text font-heading font-medium">( 89 reviews )</span>
                    </div>
                </div>
                <!-- About This Room -->
                <div class="rounded-[8px] border border-[#E1DFDF] p-6 mt-6">
                    <h2 class="text-lg font-medium text-color mb-3 font-heading">About This Room</h2>
                    <p class="leading-[25px] text-sm font-heading font-regular text-body text-justify">
                        This spacious private room offers the perfect blend of comfort and functionality. Featuring
                        modern amenities and thoughtful design, it's ideal for students and professionals seeking a peaceful
                        living environment. The room comes fully furnished with comfortable bedding, ample storage space,
                        and a
                        dedicated work area. Natural light floods through large windows, creating a bright and welcoming
                        atmosphere. Located in a prime block with easy access to common areas and facilities.
                    </p>
                </div>
                <div class="rounded-[8px] border border-[#E1DFDF] p-6 mb-6 mt-6">
                    <h2 class="text-lg font-medium text-color mb-6 font-heading">Room Features</h2>
                    <div class="flex flex-col">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pb-4">
                            <!-- Beds -->
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-[#087878]/5 p-4 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="24"
                                        height="24" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M6.75 4h10.5a2.75 2.75 0 0 1 2.745 2.582L20 6.75v3.354a2.75 2.75 0 0 1 1.994 2.459l.006.187v7.5a.75.75 0 0 1-1.493.102l-.007-.102V18h-17v2.25a.75.75 0 0 1-.648.743L2.75 21a.75.75 0 0 1-.743-.648L2 20.25v-7.5c0-1.259.846-2.32 2-2.647V6.75a2.75 2.75 0 0 1 2.582-2.745zm12.5 7.5H4.75a1.25 1.25 0 0 0-1.244 1.122l-.006.128v3.75h17v-3.75a1.25 1.25 0 0 0-1.122-1.243zm-2-6H6.75a1.25 1.25 0 0 0-1.244 1.122L5.5 6.75V10H7a1 1 0 0 1 1-1h2a1 1 0 0 1 .993.883L11 10h2a1 1 0 0 1 1-1h2a1 1 0 0 1 .993.883L17 10h1.5V6.75a1.25 1.25 0 0 0-1.122-1.244z"
                                            stroke-width="0.3" stroke="currentColor" />
                                    </svg>
                                </div>
                                <h3 class="font-heading text-sm sub-text font-regular mb-1">Bed</h3>
                                <p class="text-color text-base font-heading font-medium">{{ $room->beds->count() }}</p>
                            </div>
                            <!-- Size -->
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-[#087878]/5 p-4 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="24"
                                        height="24" viewBox="0 0 16 16">
                                        <path fill="currentColor"
                                            d="M6.5 2h-2A2.5 2.5 0 0 0 2 4.5a.5.5 0 0 0 1 0A1.5 1.5 0 0 1 4.5 3h2a.5.5 0 0 0 0-1M2 11.5A2.5 2.5 0 0 0 4.5 14h3a2.5 2.5 0 0 0 2.5-2.5v-3A2.5 2.5 0 0 0 7.5 6h-3A2.5 2.5 0 0 0 2 8.5zm9.5 2.5a.5.5 0 0 1 0-1a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 1 1 0v2a2.5 2.5 0 0 1-2.5 2.5M14 6.5a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 0 11.5 3h-2a.5.5 0 0 1 0-1h2A2.5 2.5 0 0 1 14 4.5z" />
                                    </svg>
                                </div>
                                <h3 class="font-heading text-sm sub-text font-regular mb-1">Size</h3>
                                <p class="text-color text-base font-heading font-medium">
                                    @if ($room->room_size)
                                        {{ $room->room_size }} sq ft
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <!-- Capacity -->
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-[#087878]/5 p-4 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="24"
                                        height="24" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <path d="M18 21a8 8 0 0 0-16 0" />
                                            <circle cx="10" cy="8" r="5" />
                                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                                        </g>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-sm sub-text font-regular mb-1">Capacity</h3>
                                <p class="text-color text-base font-heading font-medium">
                                    @if ($room->beds)
                                        {{ $room->beds->count() }}
                                        person
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <!-- Bathroom -->
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-[#087878]/5 p-4 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="24"
                                        height="24" viewBox="0 0 24 24">
                                        <g fill="none">
                                            <path d="M21 3h-9v18h9z" />
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M12 3h9v9m-9-9v9m0-9l9 9m-9 0v9h9m-9-9l9 9m0 0v-9" />
                                            <path stroke="currentColor" stroke-width="2" d="M3 3v18h18V3z" />
                                        </g>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-sm sub-text font-regular mb-1">Bathroom</h3>
                                <p class="text-color text-base font-heading font-medium">
                                    @if ($room->has_attached_bathroom)
                                        Attached
                                    @else
                                        Shared
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class=" border-b border-[#E1DFDF] mb-6 mt-6 w-full">
                        </div>
                        <!-- What Included -->
                        <h2 class="text-base mt-3 font-medium text-color mb-3 font-heading">What Included</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach (json_decode($room->room_inclusions) ?? [] as $inclusion)
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="16"
                                        height="16" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M4 12a8 8 0 1 1 16 0a8 8 0 0 1-16 0m8-10C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2m5.457 7.457l-1.414-1.414L11 13.086l-2.793-2.793l-1.414 1.414L11 15.914z" />
                                    </svg>
                                    <span class="text-body text-sm font-heading font-regular">{{ $inclusion }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Amenities -->
                <div class="rounded-[8px] border border-[#E1DFDF] p-6">
                    <h2 class="text-lg font-medium text-color mb-6 font-heading">Amenities</h2>
                    @if ($room->roomAmenities->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach ($room->roomAmenities as $amenity)
                                <div class="flex items-center gap-3 bg-[#F1F4F4] rounded-[8px] p-4">
                                    @if ($amenity->amenity_icon)
                                        <img class="w-5 h-5 text-[#087878]"
                                            src="{{ asset('storage/images/icons/' . $amenity->amenity_icon) }}"
                                            alt="{{ $amenity->amenity_name }}">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#087878]"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                        </svg>
                                    @endif
                                    <span
                                        class="text-sm text-body font-heading font-regular">{{ $amenity->amenity_name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No amenities listed for this room</p>
                    @endif
                </div>

            </div>

            <!-- Right Section with Sticky Cards -->
            <div class="lg:w-1/3 space-y-6">
                <!-- Price Card - Sticky -->
                <div class="sticky top-[180px]">
                    <div class="bg-white rounded-[8px] border border-[#E1DFDF] p-6 mb-6">
                        <div class="text-center mb-2">
                            <h3 class="text-3xl font-bold text-color font-heading">
                                @if ($room->occupancy)
                                    NPR {{ number_format($room->occupancy->monthly_rent) }}
                                @else
                                    Price not set
                                @endif
                            </h3>
                            <p class="text-body text-sm font-heading font-regular">Per person/month</p>
                            <div class=" border-b border-[#E1DFDF] mb-6 mt-6 w-full">
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <!-- Capacity -->
                            <div class="flex justify-between items-center">
                                <span class="sub-text text-sm font-heading font-regular">Capacity:</span>
                                <span class="text-color text-sm font-medium font-heading">
                                    @if ($room->beds)
                                        {{ $room->beds->count() }}
                                        guest{{ $room->beds->count() != 1 ? 's' : '' }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <!-- Status -->
                            <div class="flex justify-between items-center">
                                <span class="sub-text text-sm font-heading font-regular">Status:</span>
                                <span class="text-color text-sm font-medium font-heading">
                                    @php
                                        $availableBeds = $room->beds->where('status', 'Available')->count();
                                    @endphp
                                    @if ($availableBeds > 0)
                                        Available ({{ $availableBeds }}/{{ $room->beds->count() }})
                                    @else
                                        Occupied
                                    @endif
                                </span>
                            </div>
                            <!-- Location -->
                            <div class=" flex justify-between items-center">
                                <span class="sub-text text-sm font-heading font-regular">Location:</span>
                                <span
                                    class="text-color text-sm font-medium font-heading">{{ $room->floor->block->location }}</span>
                            </div>
                            <!-- Rating -->
                            <div class="flex justify-between items-center">
                                <span class="sub-text text-sm font-heading font-regular">Rating:</span>
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#FBBF24]"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                    <span class="text-color text-sm font-medium font-heading">4.5/5</span>
                                </div>
                            </div>
                        </div>
                        <div class=" border-b border-[#E1DFDF] mb-6 mt-6 w-full">
                        </div>
                        <!-- Meal Options -->
                        {{-- <div class="mb-6">
                            <span class="text-color text-sm font-medium font-heading block mb-3">Meal</span>
                            <div class="flex gap-10">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="meal"
                                        class="w-4 h-4 text-[#00A0B0] border-gray-300 focus:ring-[#00A0B0]">
                                    <span class="text-color text-sm font-heading">With meal</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="meal"
                                        class="w-4 h-4 text-[#00A0B0] border-gray-300 focus:ring-[#00A0B0]">
                                    <span class="text-color text-sm font-heading">Without meal</span>
                                </label>
                            </div>
                        </div> --}}
                        @php
                            $availableBedsForBooking = $room->beds->where('status', 'Available')->count();
                        @endphp
                        @if ($availableBedsForBooking > 0)
                            <a href="{{ route('hostel.checkout', [$hostel->slug, $room->slug]) }}"
                                class="block w-full bg-[#00A1A5] hover:bg-[#076166] font-heading text-base text-white font-bold py-3 px-6 rounded-full transition-colors duration-200 mb-2 text-center">
                                Book this now
                            </a>
                        @else
                            <button disabled
                                class="block w-full bg-gray-400 cursor-not-allowed font-heading text-base text-white font-bold py-3 px-6 rounded-full mb-2 text-center opacity-60"
                                title="No beds available">
                                Fully Booked
                            </button>
                        @endif
                        <div class="text-center mt-4">
                            <a href="#" class="text-color font-heading text-base font-bold hover:text-[#076166]">
                                Login to book
                            </a>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="bg-white rounded-[8px] p-6 border border-[#E1DFDF] justify-center text-center">
                        <span class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-4" width="40" height="40"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-7 12h-2v-2h2zm1.8-5c-.3.4-.7.6-1.1.8c-.3.2-.4.3-.5.5c-.2.2-.2.4-.2.7h-2c0-.5.1-.8.3-1.1c.2-.2.6-.5 1.1-.8c.3-.1.5-.3.6-.5s.2-.5.2-.7c0-.3-.1-.5-.3-.7s-.5-.3-.8-.3s-.5.1-.7.2q-.3.15-.3.6h-2c.1-.7.4-1.3.9-1.7s1.2-.5 2.1-.5s1.7.2 2.2.6s.8 1 .8 1.7q.15.6-.3 1.2" />
                            </svg>
                            <h3 class="text-xl font-bold text-color mb-4 font-heading">Still Have Questions?</h3>
                        </span>

                        <p class="text-body text-sm font-regular mb-4 font-heading">Our friendly team is here to help you
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
            </div>
        </div>

        <!-- Student Reviews Section -->

        <div class="max-w-[1920px] mx-auto mt-10">
            <h2 class="text-2xl md:text-xl font-bold text-color mb-4 font-heading tracking-tight">Student who stayed here
                loved</h2>
            <div class="w-full md:w-full h-[0.5px] bg-[#E1DFDF]"></div>
            <div class="relative">
                <!-- Previous Button -->
                <button onclick="prevSlide()"
                    class="absolute left-0 top-2/3 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white rounded-full shadow-custom-combo border border-gray-200 text-gray-600 hover:text-[#087878] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                    </svg>
                </button>

                <!-- Next Button -->
                <button onclick="nextSlide()"
                    class="absolute right-0 top-2/3 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white rounded-full shadow-custom-combo border border-gray-200 text-gray-600 hover:text-[#087878] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                    </svg>
                </button>

                <div class="overflow-hidden px-4">
                    <div class="flex mt-6 transition-transform duration-500 ease-in-out gap-6" id="carouselTrack">
                        <!-- Card 1 -->
                        <div
                            class="min-w-full h-full sm:min-w-[calc(60%-12px)] lg:min-w-[calc(33.333%-16px)] bg-white rounded-[8px] p-6 shadow-custom-combo border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img=1" alt="Paul"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-base font-heading font-bold text-[#1a1a1a] mb-0">Paul</h3>
                                    <div class="flex items-center gap-1 text-xs font-medium sub-text">
                                        <span>Wed 27/10/2025</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm leading-[25px] font-regular text-body text-justify font-heading">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum, lacus non
                                efficitur viverra, mauris mi fermentum urna, vitae posuere lectus mi sit amet odio.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div
                            class="min-w-full h-full sm:min-w-[calc(60%-12px)] lg:min-w-[calc(33.333%-16px)] bg-white rounded-[8px] p-6 shadow-custom-combo border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img=1" alt="Paul"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-base font-heading font-bold text-[#1a1a1a] mb-0">Paul</h3>
                                    <div class="flex items-center gap-1 text-xs font-medium sub-text">
                                        <span>Wed 27/10/2025</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm leading-[25px] font-regular text-body text-justify font-heading">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum, lacus non
                                efficitur viverra, mauris mi fermentum urna, vitae posuere lectus mi sit amet odio.
                            </p>
                        </div>


                        <!-- Card 3 -->
                        <div
                            class="min-w-full h-full sm:min-w-[calc(60%-12px)] lg:min-w-[calc(33.333%-16px)] bg-white rounded-[8px] p-6 shadow-custom-combo border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img=1" alt="Paul"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-base font-heading font-bold text-[#1a1a1a] mb-0">Paul</h3>
                                    <div class="flex items-center gap-1 text-xs font-medium sub-text">
                                        <span>Wed 27/10/2025</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm leading-[25px] font-regular text-body text-justify font-heading">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum, lacus non
                                efficitur viverra, mauris mi fermentum urna, vitae posuere lectus mi sit amet odio.
                            </p>
                        </div>


                        <!-- Card 4 -->
                        <div
                            class="min-w-full h-full sm:min-w-[calc(60%-12px)] lg:min-w-[calc(33.333%-16px)] bg-white rounded-[8px] p-6 shadow-custom-combo border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img=1" alt="Paul"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-base font-heading font-bold text-[#1a1a1a] mb-0">Paul</h3>
                                    <div class="flex items-center gap-1 text-xs font-medium sub-text">
                                        <span>Wed 27/10/2025</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm leading-[25px] font-regular text-body text-justify font-heading">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum, lacus non
                                efficitur viverra, mauris mi fermentum urna, vitae posuere lectus mi sit amet odio.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            let currentSlide = 0;
            const track = document.getElementById('carouselTrack');
            const cards = track.children;
            const totalCards = cards.length;

            function getCardsPerView() {
                if (window.innerWidth <= 640) return 1;
                if (window.innerWidth <= 1024) return 2;
                return 3;
            }

            function updateCarousel() {
                const cardsPerView = getCardsPerView();
                const cardWidth = cards[0].offsetWidth;
                const gap = 24; // This matches the gap-6 class (1.5rem = 24px)
                const offset = currentSlide * (cardWidth + gap);
                track.style.transform = `translateX(-${offset}px)`;
            }

            function nextSlide() {
                const cardsPerView = getCardsPerView();
                const maxSlide = totalCards - cardsPerView;
                if (currentSlide < maxSlide) {
                    currentSlide++;
                    updateCarousel();
                }
            }

            function prevSlide() {
                if (currentSlide > 0) {
                    currentSlide--;
                    updateCarousel();
                }
            }

            // Initialize carousel and add resize listener
            document.addEventListener('DOMContentLoaded', () => {
                updateCarousel();
                window.addEventListener('resize', () => {
                    const cardsPerView = getCardsPerView();
                    const maxSlide = totalCards - cardsPerView;
                    if (currentSlide > maxSlide) {
                        currentSlide = maxSlide;
                    }
                    updateCarousel();
                });
            });
        </script>
    </div>

    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var thumbSwiper = new Swiper(".thumbSwiper", {
                spaceBetween: 8,
                slidesPerView: 4,
                watchSlidesProgress: true,
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                        spaceBetween: 6
                    },
                    480: {
                        slidesPerView: 4,
                        spaceBetween: 8
                    },
                    640: {
                        slidesPerView: 5,
                        spaceBetween: 8
                    }
                }
            });

            var mainSwiper = new Swiper(".mainSwiper", {
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                thumbs: {
                    swiper: thumbSwiper,
                },
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
            });
        });
    </script>

    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var thumbSwiper = new Swiper(".thumbSwiper", {
                spaceBetween: 8,
                slidesPerView: 4,
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                        spaceBetween: 6
                    },
                    480: {
                        slidesPerView: 4,
                        spaceBetween: 8
                    },
                    640: {
                        slidesPerView: 5,
                        spaceBetween: 8
                    }
                },
                freeMode: true,
                watchSlidesProgress: true,
            });

            var mainSwiper = new Swiper(".mainSwiper", {
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                thumbs: {
                    swiper: thumbSwiper,
                },
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
            });
        });
    </script>
@endsection
