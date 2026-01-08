@extends('frontend.layouts.mainPortal')

@section('body')
    <!-- Hsotels Banner start -->
    <section class="bg-[#e0e2e5] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-20 flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Hostels
            </h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">All Stays</span>
            </nav>
        </div>
    </section>
    <!-- Hostels Banner end -->

    <!-- All Hostel list Section start -->
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-20 py-8">
        <div class="flex flex-col md:flex-row gap-2 md:items-start">
            <!-- Filters Sidebar -->
            <aside class="md:w-1/4 md:flex-shrink-0">
                <div class="bg-gray-50 px-4 pb-8">
                    <div class="pt-6 pb-4">
                        <h5 class="text-xl font-semibold text-color font-heading">Suggested For You</h5>
                    </div>

                    <!-- Room Type -->
                    <div class="bg-white rounded-lg box-shadow p-6 mb-4">
                        <h6 class="font-medium text-color font-heading mb-4">Room type</h6>
                        <div class="space-y-4">
                            @foreach ($roomTypes as $type)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="roomType" value="{{ $type }}"
                                        class="w-4 h-4 border-[#627084] text-blue-600 focus:ring-0 focus:ring-offset-0">
                                    <span class="ml-3 text-sm font-heading sub-text font-regular">
                                        {{ ucfirst($type) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <!-- Price Range -->

                    <div class="bg-white rounded-lg box-shadow p-6 mb-4">
                        <h6 class="font-medium text-color font-heading mb-4">Price Range</h6>
                        <div class="flex items-center space-x-3">
                            <input type="number"
                                class="w-full px-3 py-2 border border-[#DCDFE5] rounded-sm focus:ring-0 focus:border-[#DCDFE5] text-sm"
                                placeholder="Min">
                            <span class="text-gray-400">-</span>
                            <input type="number"
                                class="w-full px-3 py-2 border border-[#DCDFE5] rounded-sm focus:ring-0 focus:border-[#DCDFE5] text-sm"
                                placeholder="Max">
                        </div>
                    </div>

                    <!-- User Rating -->
                    <div class="bg-white rounded-lg box-shadow p-6 mb-4">
                        <h6 class="font-medium text-color font-heading mb-4">User Rating</h6>
                        <div class="space-y-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="rating" value="4.5"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">4.5+ (Excellent)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="rating" value="4.0"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">4.0+ (Very Good)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="rating" value="3.5"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">3.5+ (Good)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="rating" value="3.0"
                                    class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                <span class="ml-3 text-sm font-heading sub-text font-regular">3.0+ (Average)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Occupancy/Capacity -->
                    {{-- <div class="bg-white rounded-lg box-shadow p-6 mb-4">
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
                    </div> --}}

                    <!-- Amenities -->
                    <div class="bg-white rounded-lg box-shadow p-6 mb-4">
                        <h6 class="font-medium text-color font-heading mb-4">Amenities</h6>
                        <div class="space-y-4">
                            @foreach ($amenities as $amenity)
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" value="{{ $amenity->amenity_name }}"
                                        class="w-4 h-4 rounded-sm border-[#627084] text-blue-600 focus:ring-0">
                                    <span
                                        class="ml-3 text-sm font-heading sub-text font-regular">{{ $amenity->amenity_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Room Listings -->
            <div class="md:flex-1 w-full">
                <!-- Cards Container -->
                {{-- <div id="activeFilters" class="flex flex-wrap gap-2 mb-4">
                    <div
                        class="inline-flex items-center border border-[#E1DFDF] text-color px-4 py-2 font-heading rounded-full text-sm">
                        Very good: 8+ <button class="ml-2 sub-text hover-text-color">&times;</button>
                    </div>
                    <div
                        class="inline-flex items-center border border-[#E1DFDF] text-color px-4 py-2 font-heading rounded-full text-sm">
                        No prepayment <button class="ml-2 sub-text hover-text-color">&times;</button>
                    </div>
                </div> --}}
                <div id="hostel-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 min-h-[400px]">
                    @include('frontend.mainPortal.partials.filteredHostel', ['hostels' => $hostels])
                </div>
                <div class="text-center mt-8">
                    <button id="load-more"
                        class="button-color text-color hover:bg-[#023be4] text-sm hover:text-[white] border border-color font-semibold px-6 py-2 rounded-full transition-colors duration-300 ">
                        Load More
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Trigger filter when any input changes
            $('input[name="roomType"], input[type="checkbox"], input[type="number"]').on('change keyup',
                function() {
                    filterHostels();
                });

            function filterHostels() {
                let roomType = $('input[name="roomType"]:checked').val() || '';
                let minPrice = $('input[placeholder="Min"]').val();
                let maxPrice = $('input[placeholder="Max"]').val();

                console.log(minPrice);
                console.log(maxPrice);

                // Collect all selected ratings
                let ratings = [];
                $('input[name="rating"]:checked').each(function() {
                    ratings.push($(this).val());
                });

                // Collect all selected amenities (excluding rating checkboxes)
                let amenities = [];
                $('.bg-white.rounded-lg input[type="checkbox"]:checked').not('input[name="rating"]').each(
                    function() {
                        amenities.push($(this).next('span').text().trim());
                    });

                $.ajax({
                    url: "{{ route('hostel.filter') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        roomType: roomType,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        amenities: amenities,
                        ratings: ratings
                    },
                    beforeSend: function() {
                        $('#hostel-container').html(
                            '<div class="col-span-full text-center py-10 text-gray-500 flex items-center justify-center min-h-[400px]"><div><i class="fas fa-spinner fa-spin text-3xl mb-2"></i><p>Loading hostels...</p></div></div>'
                        );
                    },
                    success: function(res) {
                        $('#hostel-container').html(res.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

        });
    </script>
    <script>
        let offset = 3; // initially loaded 3
        const limit = 3;

        $('#load-more').on('click', function() {
            $.ajax({
                url: "{{ route('hostel') }}",
                type: "GET",
                data: {
                    offset: offset,
                    limit: limit
                },
                beforeSend: function() {
                    $('#load-more').prop('disabled', true).text('Loading...');
                },
                success: function(response) {
                    if ($.trim(response) === '') {
                        $('#load-more').hide();
                    } else {
                        $('#hostel-container').append(response);
                        offset += limit;
                        $('#load-more').prop('disabled', false).text('Load More');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading more hostels:', error);
                    $('#load-more').prop('disabled', false).text('Load More');
                }
            });
        });
    </script>
    <script>
        const loadMoreBtn = document.getElementById('load-more');

        // Call this whenever filters change
        function updateLoadMoreVisibility() {
            const anyFilterActive =
                document.querySelectorAll('input[type="checkbox"]:checked').length > 0 ||
                document.querySelectorAll('input[type="radio"]:checked').length > 0 ||
                document.querySelector('#selectedLocation').dataset.value !== 'All Cities' ||
                document.querySelector('input[type="text"]').value.length >= 3; // or whatever triggers search

            loadMoreBtn.style.display = anyFilterActive ? 'none' : 'inline-block';
        }

        // Add event listeners for filters
        document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(el => {
            el.addEventListener('change', updateLoadMoreVisibility);
        });

        // Location dropdown
        document.querySelectorAll('.dropdown-item').forEach(el => {
            el.addEventListener('click', () => {
                updateLoadMoreVisibility();
            });
        });

        // Search input
        document.querySelector('input[type="text"]').addEventListener('input', () => {
            updateLoadMoreVisibility();
        });

        // Initial call on page load
        updateLoadMoreVisibility();
    </script>
    <!-- All hostel section end -->
@endsection
