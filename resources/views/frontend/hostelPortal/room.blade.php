@extends('frontend.layouts.hostelPortal')
@section('body')
    <!-- Room Banner start -->
    <section class="bg-[#E5E4E2] w-full h-[80px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Rooms</h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">Rooms</span>
            </nav>
        </div>
    </section>
    <!-- Room Banner end -->

    <!-- Room Listing Section -->
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] py-8">
        <div class="flex flex-col md:flex-row gap-2">
            <!-- Filters Sidebar -->
            <div class="md:w-1/4">
                <div class="bg-gray-50 px-4">
                    <div class="pt-6 pb-4">
                        <h5 class="text-xl font-semibold text-color font-heading">Suggested For You</h5>
                    </div>

                    <!-- Room Type -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4">
                        <h6 class="font-medium text-color font-heading mb-4">Room type</h6>
                        <div class="space-y-4">
                            @forelse($occupancyTypes as $type)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="roomType" value="{{ $type }}"
                                        class="w-4 h-4 border-[#627084] text-blue-600 focus:ring-0 focus:ring-offset-0">
                                    <span class="ml-3 text-sm font-heading sub-text font-regular">{{ $type }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">No room types available</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Block -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4 border border-gray-100">
                        <h6 class="font-medium text-color font-heading mb-4">Block</h6>
                        <div class="space-y-4">
                            @forelse($blocks as $block)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="block[]" value="{{ $block->id }}"
                                        class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                    <span class="ml-3 text-sm font-heading sub-text font-regular">{{ $block->name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">No blocks available</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4 border border-gray-100">
                        <h6 class="font-medium text-color font-heading mb-4">Price Range</h6>
                        <div class="flex items-center space-x-3">
                            <input type="number" name="min_price"
                                class="w-full px-3 py-2 border border-[#DCDFE5] rounded-[4px] focus:ring-0 focus:border-[#DCDFE5] text-sm"
                                placeholder="Min" min="{{ $priceRange->min_price ?? 0 }}"
                                value="{{ $priceRange->min_price ?? '' }}">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="max_price"
                                class="w-full px-3 py-2 border border-[#DCDFE5] rounded-[4px] focus:ring-0 focus:border-[#DCDFE5] text-sm"
                                placeholder="Max" max="{{ $priceRange->max_price ?? 0 }}"
                                value="{{ $priceRange->max_price ?? '' }}">
                        </div>
                        @if ($priceRange)
                            <p class="text-xs text-gray-500 mt-2">Range: NPR {{ number_format($priceRange->min_price) }} -
                                NPR {{ number_format($priceRange->max_price) }}</p>
                        @endif
                    </div>

                    <!-- User Rating -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4 border border-gray-100">
                        <h6 class="font-medium text-color font-heading mb-4">User Rating</h6>
                        <div class="space-y-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">4.5 (Above Excellent)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">4+ (Very Good)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">3+ (Good)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Occupancy/Capacity -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4 border border-gray-100">
                        <h6 class="font-medium text-color font-heading mb-4">Occupancy/Capacity</h6>
                        <div class="space-y-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">1 Person</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">2 Person</span>
                            </label>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="bg-white rounded-[8px] shadow-custom-combo p-6 mb-4 border border-gray-100">
                        <h6 class="font-medium text-color font-heading mb-4">Amenities</h6>
                        <div class="space-y-4">
                            @forelse($hostel->amenities as $amenity)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                        class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                    <span
                                        class="ml-3 text-sm font-heading sub-text font-regular">{{ $amenity->amenity_name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">No amenities available</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Listings -->
            <div class="md:w-3/4">
                <div class="bg-gray-50 pt-6">
                    <!-- Results Count -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 font-heading">
                            Showing <span class="font-semibold" id="room-count">{{ $rooms->count() }}</span>
                            <span id="room-text">room{{ $rooms->count() != 1 ? 's' : '' }}</span>
                        </p>
                    </div>

                    <div id="rooms-container">
                        @include('frontend.hostelPortal.partials.filteredRooms', [
                            'rooms' => $rooms,
                            'hostel' => $hostel,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Trigger filter when any input changes
            $('input[name="roomType"], input[name="block[]"], input[name="min_price"], input[name="max_price"], input[name="amenities[]"]')
                .on('change keyup',
                    function() {
                        filterRooms();
                    });

            function filterRooms() {
                let roomType = $('input[name="roomType"]:checked').val() || '';
                let minPrice = $('input[name="min_price"]').val() || '';
                let maxPrice = $('input[name="max_price"]').val() || '';

                // Collect all selected blocks
                let blocks = [];
                $('input[name="block[]"]:checked').each(function() {
                    blocks.push($(this).val());
                });

                // Collect all selected amenities
                let amenities = [];
                $('input[name="amenities[]"]:checked').each(function() {
                    amenities.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('hostel.room.filter', $hostel->slug) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        roomType: roomType,
                        blocks: blocks,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        amenities: amenities
                    },
                    beforeSend: function() {
                        $('#rooms-container').html(
                            '<div class="col-span-3 text-center py-10 text-gray-500">Loading rooms...</div>'
                        );
                    },
                    success: function(res) {
                        $('#rooms-container').html(res.html);
                        $('#room-count').text(res.count);
                        $('#room-text').text(res.count === 1 ? 'room' : 'rooms');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#rooms-container').html(
                            '<div class="col-span-3 text-center py-10 text-red-500">Error loading rooms. Please try again.</div>'
                        );
                    }
                });
            }
        });
    </script>
@endsection
