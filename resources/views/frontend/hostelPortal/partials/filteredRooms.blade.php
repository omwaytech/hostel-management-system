@forelse($rooms as $room)
    <div class="room-card rounded-[8px] shadow-custom-combo p-0 mb-4 bg-white">
        <div class="flex flex-col lg:flex-row">
            <!-- Image Section -->
            <div class="flex-shrink-0 rounded-2xl">
                @if ($room->photo)
                    <img src="{{ asset('storage/images/roomPhotos/' . $room->photo) }}"
                        alt="Room {{ $room->room_number }}"
                        class="p-4 md:p-4 w-full lg:w-[240px] h-full object-cover rounded-3xl">
                @else
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=400&h=300&fit=crop"
                        alt="Room {{ $room->room_number }}"
                        class="p-4 md:p-4 w-full lg:w-[240px] h-full object-cover rounded-3xl">
                @endif
            </div>

            <!-- Details Section -->
            <div class="flex-grow p-4 md:p-4 pt-0 lg:pt-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h2 class="text-xl md:text-xl font-bold text-color font-heading">
                                Room {{ $room->room_number }}
                            </h2>
                            @if ($room->room_type)
                                <div class="flex gap-0.5">
                                    @for ($i = 0; $i < 3; $i++)
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        @if ($room->floor && $room->floor->block)
                            <div
                                class="inline-flex items-center border border-[#E1DFDF] text-subcolor/10 px-3 py-1 rounded-md text-sm font-medium">
                                {{ $room->floor->block->name }}
                            </div>
                        @endif
                    </div>
                </div>

                <p class="sub-text font-heading font-regular text-sm mb-3">
                    @if ($room->occupancy)
                        Type/Capacity: {{ $room->occupancy->occupancy_type }}
                    @endif
                    @if ($room->beds->count() > 0)
                        • {{ $room->beds->count() }} bed{{ $room->beds->count() != 1 ? 's' : '' }}
                    @endif
                </p>

                <!-- Room Amenities -->
                <div class="flex flex-wrap items-center gap-4 mb-4 font-heading text-sm font-regular">
                    @if ($room->roomAmenities->count() > 0)
                        @foreach ($room->roomAmenities->take(3) as $roomAmenity)
                            <div class="flex items-center gap-2 sub-text">
                                @if ($roomAmenity->amenity_icon)
                                    <img class="w-5 h-5"
                                        src="{{ asset('storage/images/icons/' . $roomAmenity->amenity_icon) }}"
                                        alt="">
                                    {{-- <i ></i> --}}
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                                <span>{{ $roomAmenity->amenity_name }}</span>
                            </div>
                        @endforeach
                        @if ($room->roomAmenities->count() > 3)
                            <span class="text-xs sub-text">+{{ $room->roomAmenities->count() - 3 }} more</span>
                        @endif
                    @else
                        <span class="text-sm text-gray-500">No amenities listed</span>
                    @endif
                </div>

                @if ($room->room_size || $room->has_attached_bathroom)
                    <div class="flex gap-4 text-xs sub-text">
                        @if ($room->room_size)
                            <span>• Size: {{ $room->room_size }} sq ft</span>
                        @endif
                        @if ($room->has_attached_bathroom)
                            <span>• Attached Bathroom</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Price Section -->
            <div class="flex-shrink-0 lg:text-right border-t lg:border-t-0 lg:border-l border-[#E1DFDF] p-4 md:p-6">
                <div class="flex lg:flex-col items-center lg:items-end justify-between lg:justify-start gap-2 lg:gap-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[#1F625F] text-xl font-bold">Available</span>
                            @php
                                $availableBeds = $room->beds->where('status', 'Available')->count();
                                $totalBeds = $room->beds->count();
                            @endphp
                            @if ($totalBeds > 0)
                                <div class="bg-teal-700 text-white px-2 py-1 rounded font-bold text-sm">
                                    {{ $availableBeds }}/{{ $totalBeds }}
                                </div>
                            @endif
                        </div>
                        <p class="sub-text font-heading font-medium text-sm mt-2 tracking-tight">
                            {{ $availableBeds }} bed{{ $availableBeds != 1 ? 's' : '' }} available
                        </p>
                    </div>

                    <div class="text-right">
                        @if ($room->occupancy)
                            <div class="text-xl md:text-2xl font-heading font-bold text-color mb-1">
                                NPR {{ number_format($room->occupancy->monthly_rent) }}
                            </div>
                            <p class="sub-text font-heading tracking-tight font-regular text-sm">
                                per month
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Price not set</p>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('hostel.roomDetail', [$hostel->slug, $room->slug]) }}"
                        class="inline-flex bg-[#076166] hover:bg-[#003135] rounded-full text-white px-6 py-2 font-bold font-heading transition-colors duration-200 items-center gap-2">
                        More details
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="bg-white rounded-[8px] shadow-custom-combo p-8 text-center col-span-full">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <h3 class="mt-2 text-xl font-semibold text-gray-900 font-heading">No rooms available</h3>
        <p class="mt-1 text-sm text-gray-500">No rooms match your filter criteria. Try adjusting your filters.</p>
    </div>
@endforelse
