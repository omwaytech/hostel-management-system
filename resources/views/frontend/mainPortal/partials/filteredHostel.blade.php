@forelse ($hostels as $hostel)
    <div class="flex-none w-full">
        <div class="bg-white rounded-[20px] border border-color box-shadow  overflow-hidden">
            <!-- Image Slider -->
            <div class="relative image-slider-wrapper">
                <div class="image-slider">
                    <div class="image-slides flex transition-transform duration-300">
                        @foreach ($hostel->images as $img)
                            <img src="{{ asset('storage/images/hostelImages/' . $img->image) }}" alt="{{ $hostel->name }}"
                                class="w-full h-48 object-cover flex-none">
                        @endforeach
                    </div>

                    <!-- Prev/Next Buttons -->
                    <button
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-100"
                        onclick="changeImage(this, -1)">
                        <i class="fas fa-chevron-left text-sm text-gray-700"></i>
                    </button>
                    <button
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-100"
                        onclick="changeImage(this, 1)">
                        <i class="fas fa-chevron-right text-sm text-gray-700"></i>
                    </button>

                    <!-- Dots -->
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1">
                        @foreach ($hostel->images as $index => $img)
                            <span
                                class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white dot active' : 'bg-white/50 dot' }}"></span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-base font-medium font-heading text-color opacity-80">
                        {{ $hostel->name }}
                    </h3>
                    @if ($hostel->average_rating > 0)
                        <div class="flex items-center gap-1 flex-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-[#FACC15]" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.12 9.88a.74.74 0 0 0-.6-.51l-5.42-.79l-2.43-4.91a.78.78 0 0 0-1.34 0L8.9 8.58l-5.42.79a.74.74 0 0 0-.6.51a.75.75 0 0 0 .18.77L7 14.47l-.93 5.4a.76.76 0 0 0 .3.74a.75.75 0 0 0 .79.05L12 18.11l4.85 2.55a.73.73 0 0 0 .35.09a.8.8 0 0 0 .44-.14a.76.76 0 0 0 .3-.74l-.94-5.4l3.93-3.82a.75.75 0 0 0 .19-.77" />
                            </svg>
                            <span
                                class="font-medium font-heading text-base text-color">{{ number_format($hostel->average_rating, 1) }}</span>
                            <span class="sub-text font-heading text-sm">({{ $hostel->review_count }})</span>
                        </div>
                    @else
                        <div class="flex items-center gap-1 flex-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.12 9.88a.74.74 0 0 0-.6-.51l-5.42-.79l-2.43-4.91a.78.78 0 0 0-1.34 0L8.9 8.58l-5.42.79a.74.74 0 0 0-.6.51a.75.75 0 0 0 .18.77L7 14.47l-.93 5.4a.76.76 0 0 0 .3.74a.75.75 0 0 0 .79.05L12 18.11l4.85 2.55a.73.73 0 0 0 .35.09a.8.8 0 0 0 .44-.14a.76.76 0 0 0 .3-.74l-.94-5.4l3.93-3.82a.75.75 0 0 0 .19-.77" />
                            </svg>
                            <span class="font-medium font-heading text-base text-gray-400">No ratings</span>
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#E4EAFD]" width="18" height="18"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M7 17H4C2.38 17 .96 15.74.76 14.14l-.5-2.99C.15 10.3.39 9.5.91 8.92S2.19 8 3 8h6c.83 0 1.58.35 2.06.96c.11.15.21.31.29.49c.43-.09.87-.09 1.29 0c.08-.18.18-.34.3-.49C13.41 8.35 14.16 8 15 8h6c.81 0 1.57.34 2.09.92c.51.58.75 1.38.65 2.19l-.51 3.07C23.04 15.74 21.61 17 20 17h-3c-1.56 0-3.08-1.19-3.46-2.7l-.9-2.71c-.38-.28-.91-.28-1.29 0l-.92 2.78C10.07 15.82 8.56 17 7 17" />
                    </svg>
                    <span class="font-regular text-xs font-heading text-color">
                        {{ $hostel->type }} Hostel
                    </span>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                    </svg>
                    <span class="font-regular text-sm font-heading text-[#444444]">
                        {{ $hostel->location }}
                    </span>
                </div>
                <!-- Amenities -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($hostel->amenities as $amenity)
                        <div
                            class="flex items-center text-xs text-color font-heading border gap-1 border-color rounded-xs px-3 py-1 bg-white">
                            <img src="{{ asset('storage/images/icons/' . $amenity->amenity_icon) }}"
                                alt="{{ $amenity->amenity_name }}"
                                style="width:15px; height:15px; object-fit:cover; border-radius:8px;">
                            <span>{{ $amenity->amenity_name }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- Price -->
                <div class="flex items-end justify-between border-t border-gray-200">
                    @php
                        $lowestRent = $hostel->blocks->flatMap(fn($block) => $block->occupancies)->min('monthly_rent');
                    @endphp

                    @if ($lowestRent)
                        <div>
                            <p class="text-sm font-heading sub-text mb-0.5 mt-2">From</p>
                            <p class="text-lg font-bold font-heading text-color">
                                NRP {{ number_format($lowestRent, 0) }}
                                <span class="text-sm font-normal sub-text font-regular">/ month</span>
                            </p>
                        </div>
                    @else
                        <div>
                            <p class="text-sm font-heading sub-text mb-0.5 mt-2">From</p>
                            <p class="text-lg font-bold font-heading text-color">
                                NRP 0
                                <span class="text-sm font-normal sub-text font-regular">/ month</span>
                            </p>
                        </div>
                    @endif
                    <a href="{{ route('hostelDetail', $hostel->slug) }}">
                        <button
                            class="px-5 py-2 button-color border borer-color text-color rounded-full font-heading font-medium hover:bg-[#01217f] hover:text-white transition text-xs">
                            View Details
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <p class="text-gray-500 col-span-full text-center">No hostels found.</p>
@endforelse
