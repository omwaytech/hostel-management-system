@extends('frontend.layouts.mainPortal')

@section('body')
<!-- Hero Section -->
<section class="relative w-full h-screen overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        @if (isset($systemConfigs['banner_image']) && $systemConfigs['banner_image'])
        <img src="{{ asset('storage/images/adminConfigImages/' . $systemConfigs['banner_image']) }}"
            alt="Happy travelers" class="w-full h-full object-cover">
        @endif
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 gradient-overlay bg-[#01217F]/30"></div>

    <!-- Content -->
    <div class="relative z-10 h-full flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
        <!-- Main Heading -->
        <h1
            class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-heading font-bold text-center mb-4 sm:mb-6">
            {{ $systemConfigs['banner_title'] ?? '' }}
        </h1>
        <!-- Subheading -->
        <p
            class="text-white/70 font-heading font-regular text-sm sm:text-base md:text-lg lg:text-xl text-center mb-8 sm:mb-10 md:mb-10 max-w-3xl">
            {{ $systemConfigs['banner_subtitle'] ?? '' }}
        </p>

        <!-- Search Bar -->
        <div class="w-full max-w-4xl mb-16 sm:mb-20 md:mb-16">
            <div class="bg-white rounded-full flex items-center relative">
                <!-- Location Dropdown -->
                <div class="relative" style="z-index: 50;">
                    <button type="button" id="dropdownButton"
                        class="flex items-center gap-2 px-4 sm:px-6 py-3 sm:py-2 border-r border-[#ABABAB] hover:bg-gray-50 transition-colors rounded-l-full">
                        <span id="selectedLocation"
                            class="text-gray-700 font-regular font-heading text-sm sm:text-sm md:text-base whitespace-nowrap">All
                            Cities</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600 transition-transform duration-200"
                            id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <!-- Search Input -->
                <div class="flex-1 px-4 sm:px-6 relative">
                    <input type="text" id="hostelSearch" placeholder="Start exploring hostels..."
                        class="w-full text-sm sm:text-base md:text-base text-color font-heading font-light placeholder-gray-400 outline-none bg-transparent py-3 sm:py-4">

                    <!-- Search Results Dropdown -->
                    <div id="searchResults"
                        class="absolute top-full left-0 right-0 mt-1 bg-white border border-color rounded-lg shadow-lg z-50 hidden max-h-72 overflow-auto">
                        <!-- dynamically populated -->
                    </div>
                </div>

                <!-- Search Button -->
                <button type="button" class="p-3 sm:p-4 md:p-5 hover:bg-gray-50 transition-colors rounded-r-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#21282C]/80" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                    </svg>
                </button>
            </div>
        </div>

        <script>
            const hostelsData = @json($hostels);
            let selectedCity = "All Cities";

            // --- Dropdown toggle ---
            const dropdownButton = document.getElementById('dropdownButton');
            const selectedLocation = document.getElementById('selectedLocation');

            // Create dropdown menu as fixed positioned element
            const dropdownMenu = document.createElement('div');
            dropdownMenu.id = 'dropdownMenu';
            dropdownMenu.style.display = 'none';
            dropdownMenu.style.position = 'fixed';
            dropdownMenu.style.zIndex = '9999';
            dropdownMenu.className = 'w-48 bg-white rounded-lg border border-color py-2 shadow-lg';
            dropdownMenu.innerHTML = `
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60 flex items-center gap-2" data-value="Near Me" id="nearMeOption">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Near Me
                </div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="All Cities">All Cities</div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="Kathmandu">Kathmandu</div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="Pokhara">Pokhara</div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="Lalitpur">Lalitpur</div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="Bhaktapur">Bhaktapur</div>
                <div class="dropdown-item px-4 py-2 cursor-pointer hover:bg-[#e5eeff]/60" data-value="Chitwan">Chitwan</div>
            `;
            document.body.appendChild(dropdownMenu);

            // Position dropdown below button
            function positionDropdown() {
                const rect = dropdownButton.getBoundingClientRect();
                dropdownMenu.style.top = (rect.bottom + 8) + 'px';
                dropdownMenu.style.left = rect.left + 'px';
            }

            dropdownButton.addEventListener('click', () => {
                if (dropdownMenu.style.display === 'none') {
                    positionDropdown();
                    dropdownMenu.style.display = 'block';
                } else {
                    dropdownMenu.style.display = 'none';
                }
            });

            // Dropdown selection
            dropdownMenu.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', async () => {
                    selectedCity = item.getAttribute('data-value');

                    // Handle Near Me option
                    if (selectedCity === 'Near Me') {
                        await handleNearMe();
                        return;
                    }

                    selectedLocation.textContent = selectedCity;
                    dropdownMenu.style.display = 'none';
                    filterHostels();
                });
            });

            // --- Search input ---
            const searchInput = document.getElementById('hostelSearch');
            const searchResults = document.getElementById('searchResults');

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.trim();
                if (query.length >= 3) {
                    filterHostels(query);
                } else {
                    searchResults.innerHTML = '';
                    searchResults.style.display = 'none';
                }
            });

            // --- Filtering function ---
            function filterHostels(query = '') {
                let filtered = hostelsData;

                // Filter by city if selected
                if (selectedCity !== "All Cities") {
                    filtered = filtered.filter(h => h.location === selectedCity);
                }

                // Filter by search input
                if (query.length >= 3) {
                    filtered = filtered.filter(h => h.name.toLowerCase().includes(query.toLowerCase()));
                }

                renderResults(filtered);
            }

            // --- Render results ---
            function renderResults(hostels) {
                if (hostels.length === 0) {
                    searchResults.innerHTML = '<div class="px-4 py-2 text-gray-500">No hostels found</div>';
                    searchResults.style.display = 'block';
                    return;
                }

                searchResults.innerHTML = hostels.map(h => `
                    <a href="/hostel-system/hostel-detail/${h.slug}">
                        <div class="px-4 py-3 border-b border-color hover:bg-[#e5eeff]/60 cursor-pointer flex flex-col gap-1">
                            <div class="font-medium text-color">${h.name}</div>
                            <div class="text-sm text-gray-500">${h.type} • ${h.location}</div>
                            <div class="text-xs text-gray-400">${h.amenities?.map(a => a.amenity_name).join(', ') || ''}</div>
                            ${h.distance ? `<div class="text-xs text-blue-600 font-medium">${h.distance} km away</div>` : ''}
                        </div>
                    </a>
                    `).join('');

                searchResults.style.display = 'block';
            }

            // --- Handle Near Me ---
            async function handleNearMe() {
                // Check if geolocation is supported
                if (!navigator.geolocation) {
                    alert('Geolocation is not supported by your browser');
                    return;
                }

                // Show loading state
                selectedLocation.textContent = 'Getting location...';

                try {
                    // Request user location
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        });
                    });

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Update UI
                    selectedLocation.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Near Me
                        `;
                    dropdownMenu.style.display = 'none';

                    // Fetch nearby hostels
                    const response = await fetch("{{ route('home.nearMe') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch nearby hostels');
                    }

                    const data = await response.json();

                    if (data.count === 0) {
                        searchResults.innerHTML =
                            '<div class="px-4 py-2 text-gray-500">No hostels found near you</div>';
                        searchResults.style.display = 'block';
                    } else {
                        renderResults(data.hostels);
                        // Show a success message
                        console.log(`Found ${data.count} hostels near you`);
                    }

                } catch (error) {
                    console.error('Error getting location:', error);

                    let errorMessage = 'Unable to get your location';
                    if (error.code === 1) {
                        errorMessage =
                            'Location permission denied. Please enable location access in your browser settings.';
                    } else if (error.code === 2) {
                        errorMessage = 'Location unavailable. Please check your device settings.';
                    } else if (error.code === 3) {
                        errorMessage = 'Location request timed out. Please try again.';
                    }

                    alert(errorMessage);
                    selectedLocation.textContent = 'All Cities';
                    selectedCity = 'All Cities';
                }
            }

            // Close dropdown when scrolling
            window.addEventListener('scroll', function() {
                if (dropdownMenu.style.display === 'block') {
                    dropdownMenu.style.display = 'none';
                }
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                const searchBar = document.querySelector('.bg-white.rounded-full');

                // Close search results if clicking outside search bar
                if (searchBar && !searchBar.contains(e.target)) {
                    searchResults.innerHTML = '';
                    searchResults.style.display = 'none';
                }

                // Close dropdown if clicking outside dropdown area
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });

            // Wait for DOM to be fully loaded
            // document.addEventListener('DOMContentLoaded', function() {
            //     // Dropdown functionality
            //     const dropdownButton = document.getElementById('dropdownButton');
            //     const dropdownMenu = document.getElementById('dropdownMenu');
            //     const dropdownArrow = document.getElementById('dropdownArrow');
            //     const selectedLocation = document.getElementById('selectedLocation');
            //     const dropdownItems = document.querySelectorAll('.dropdown-item');

            //     // Toggle dropdown
            //     dropdownButton.addEventListener('click', function(e) {
            //         e.preventDefault();
            //         e.stopPropagation();

            //         if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            //             dropdownMenu.style.display = 'block';
            //             dropdownArrow.style.transform = 'rotate(180deg)';
            //         } else {
            //             dropdownMenu.style.display = 'none';
            //             dropdownArrow.style.transform = 'rotate(0deg)';
            //       S  }
            //     });

            //     // Select item
            //     dropdownItems.forEach(function(item) {
            //         item.addEventListener('click', function() {
            //             const value = item.getAttribute('data-value');
            //             selectedLocation.textContent = value;
            //             dropdownMenu.style.display = 'none';
            //             dropdownArrow.style.transform = 'rotate(0deg)';
            //         });
            //     });

            //     // Close dropdown when clicking outside
            //     document.addEventListener('click', function(e) {
            //         if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            //             dropdownMenu.style.display = 'none';
            //             dropdownArrow.style.transform = 'rotate(0deg)';
            //         }
            //     });
            // });
        </script>

        <!-- Stats Section -->
        <div class="w-full max-w-3xl">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <!-- Hostels Listed -->
                <div class="flex flex-col items-center text-left">
                    <div class="text-xl font-heading sm:text-2xl md:text-3xl font-bold text-white -mb-1 ml-16">
                        {{ $systemConfigs['hostel_listed'] ?? '0' }}
                        +
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="text-sm text-white/70">Hostels Listed</span>
                    </div>
                </div>

                <!-- Happy Customers -->
                <div class="flex flex-col items-center text-left sm:border-l sm:border-[#FAFAFA]/30 sm:pl-0">
                    <div class="text-xl font-heading sm:text-2xl md:text-3xl font-bold text-white -mb-1 ml-8">
                        {{ $systemConfigs['happy_customers'] ?? '0' }}
                        +
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <span class="text-sm text-white/70">Happy Customers</span>
                    </div>
                </div>

                <!-- Trusted Owners -->
                <div class="flex flex-col items-center text-left sm:border-l sm:border-[#FAFAFA]/30 sm:pl-12">
                    <div class="text-xl font-heading sm:text-2xl md:text-3xl font-bold text-white -mb-1 ml-8">
                        {{ $systemConfigs['trusted_owners'] ?? '0' }}
                        +
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-white/80">Trusted Owners</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero section end -->

<!-- Filter section start -->
<div class="w-full bg-white min-h-[140px] md:h-auto px-4 md:px-8 lg:px-20 relative z-10 border border-gray-200"
    id="filter-section">
    <div class="h-full py-6 md:py-12">
        <div class="h-full flex flex-col justify-center">
            <div
                class="flex flex-col md:grid md:grid-cols-3 md:gap-3 lg:flex lg:flex-row lg:flex-wrap gap-4 items-stretch w-full">
                <!-- Room Type Dropdown -->
                <div class="relative w-full lg:flex-1">
                    <button onclick="toggleDropdown('roomType')"
                        class="w-full flex items-center justify-between border border-gray-300 rounded-sm px-4 h-[55px] bg-white hover:border-blue-900/60 transition-colors">
                        <div class="flex items-center flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <div class="text-left flex-1 min-w-0">
                                <label class="block text-xs text-gray-500">Room Type</label>
                                <span class="block text-sm mt-1 text-gray-900 truncate" id="roomTypeLabel">Select Room
                                    Type</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="roomTypeDropdown"
                        class="hidden absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-sm shadow-lg z-50">
                        <div class="py-1">
                            <a href="#" onclick="selectRoomType('All'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">
                                All
                            </a>
                            @foreach ($roomTypes as $type)
                            <a href="#" onclick="selectRoomType('{{ $type }}'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">
                                {{ $type }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Gender Dropdown -->
                <div class="relative w-full lg:flex-1">
                    <button onclick="toggleDropdown('gender')"
                        class="w-full flex items-center justify-between border border-gray-300 rounded-sm px-4 h-[55px] bg-white hover:border-blue-900/60 transition-colors">
                        <div class="flex items-center flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" width="24"
                                height="24" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M216 32h-48a8 8 0 0 0 0 16h28.69l-42.07 42.07a80 80 0 1 0 11.31 11.31L208 59.32V88a8 8 0 0 0 16 0V40a8 8 0 0 0-8-8m-66.76 165.29a64 64 0 1 1 0-90.53a64.1 64.1 0 0 1 0 90.53" />
                            </svg>
                            <div class="text-left flex-1 min-w-0">
                                <label class="block text-xs text-gray-500">Gender</label>
                                <span class="block text-sm mt-1 text-gray-900 truncate" id="genderLabel">Select
                                    Gender</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="genderDropdown"
                        class="hidden absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-sm shadow-lg z-50">
                        <div class="py-1">
                            <a href="#" onclick="selectGender('Boys', 'Boys Hostel'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">Boys Hostel</a>
                            <a href="#" onclick="selectGender('Girls', 'Girls Hostel'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">Girls Hostel</a>
                            <a href="#" onclick="selectGender('Co-ed', 'Co-ed Hostel'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">Co-ed Hostel</a>
                        </div>
                    </div>
                </div>

                <!-- Price Range Dropdown -->
                <div class="relative w-full lg:flex-1">
                    <button onclick="toggleDropdown('price')"
                        class="w-full flex items-center justify-between border border-gray-300 bg-white rounded-sm px-4 h-[55px] hover:border-blue-900/60 transition-colors">
                        <div class="flex items-center flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-left flex-1 min-w-0">
                                <label class="block text-xs text-gray-500">Price Range</label>
                                <span class="block text-sm mt-1 text-gray-900 truncate" id="priceLabel">Select Price
                                    Range</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="priceDropdown"
                        class="hidden absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-sm shadow-lg z-50">
                        <div class="py-1">
                            <a href="#" onclick="selectPriceRange('All', 'All', 'All'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">All</a>
                            <a href="#" onclick="selectPriceRange('5000', '10000', 'NPR 5,000 - 10,000'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">NPR 5,000 - 10,000</a>
                            <a href="#"
                                onclick="selectPriceRange('10000', '15000', 'NPR 10,000 - 15,000'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">NPR 10,000 - 15,000</a>
                            <a href="#"
                                onclick="selectPriceRange('15000', '20000', 'NPR 15,000 - 20,000'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">NPR 15,000 - 20,000</a>
                            <a href="#" onclick="selectPriceRange('20000', '100000', 'NPR 20,000+'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">NPR 20,000+</a>
                        </div>
                    </div>
                </div>
                <!-- Rating Dropdown -->
                <div class="relative w-full lg:flex-1 hidden lg:block">
                    <button onclick="toggleDropdown('rating')"
                        class="w-full flex items-center justify-between border border-gray-300 rounded-sm px-4 h-[55px] bg-white hover:border-blue-900/60 transition-colors">
                        <div class="flex items-center flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mr-3" width="24"
                                height="24" viewBox="0 0 21 21">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10.5h2l2.5-6l2 12l3-9l2.095 6l1.405-3h2" stroke-width="1" />
                            </svg>
                            <div class="text-left">
                                <label class="block text-xs text-gray-500">Rating</label>
                                <span class="block text-sm mt-1 text-gray-900" id="ratingLabel">Select Rating</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="ratingDropdown"
                        class="hidden absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-sm shadow-lg z-50">
                        <div class="py-1">
                            <a href="#" onclick="selectRating('All', 'All'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">All</a>
                            <a href="#" onclick="selectRating('5', '5 Stars'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">5 Stars</a>
                            <a href="#" onclick="selectRating('4', '4 Stars & Up'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">4 Stars & Up</a>
                            <a href="#" onclick="selectRating('3', '3 Stars & Up'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">3 Stars & Up</a>
                            <a href="#" onclick="selectRating('2', '2 Stars & Up'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">2 Stars & Up</a>
                            <a href="#" onclick="selectRating('1', '1 Star & Up'); return false;"
                                class="block px-4 py-2 text-sm hover:bg-gray-100 text-gray-900">1 Star & Up</a>
                        </div>
                    </div>
                </div>
                <!-- Rating end section -->
                <!-- Amenities Filter -->
                <div class="relative w-full md:col-span-2 lg:w-full xl:flex-1">
                    <button onclick="openAmenitiesModal()"
                        class="w-full flex items-center justify-between border border-gray-300 rounded-sm px-4 h-[55px] bg-white hover:border-blue-900/60 transition-colors">
                        <div class="flex items-center flex-1">
                            <div class="text-left flex items-center gap-2">
                                <span class="block text-sm text-gray-900">Amenities</span>
                                <span id="amenitiesCount" style="display: none;"
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">0</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Amenities Modal -->
                    <div id="amenitiesModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
                        <!-- Backdrop -->
                        <div onclick="closeAmenitiesModal()"
                            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                        <!-- Modal container -->
                        <div class="flex items-center justify-center min-h-screen px-4"
                            onclick="event.stopPropagation()">
                            <!-- Modal panel -->
                            <div class="relative bg-white rounded-lg w-full max-w-4xl">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mt-4 mb-4 lg:px-10 px-8">
                                    <h1 class="text-xl md:text-2xl font-bold text-color font-heading">Amenities</h1>
                                    <button onclick="closeAmenitiesModal()" class="text-gray-400 hover:text-gray-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Search Bar -->
                                <div class="lg:px-10 px-8 mb-5">
                                    <div class="relative">
                                        <input type="text" placeholder="Search" id="amenitySearch"
                                            onkeyup="searchAmenities()"
                                            class="w-full px-4 py-3 border border-color rounded-sm pl-10 focus:outline-none focus:ring-1 focus:ring-[#01217f]/60">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 sub-text" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Amenities Grid -->
                                <div class=" lg:px-8 px-8 mb-4">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="amenitiesGrid">
                                        @foreach ($amenities as $amenity)
                                        <label class="flex items-center space-x-3 amenity-item"
                                            data-name="{{ strtolower($amenity->amenity_name) }}">
                                            <input type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded amenity-checkbox"
                                                value="{{ $amenity->amenity_name }}" onchange="updateAmenityCount()">
                                            <span
                                                class="text-sm sub-text font-heading font-regular ">{{ $amenity->amenity_name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center p-4 border-t">
                                    <button onclick="resetAmenities()"
                                        class="px-4 py-2 text-sm text-color font-heading font-medium hover:underline">
                                        Reset
                                    </button>
                                    <button onclick="applyAmenities()"
                                        class="font-heading text-sm font-medium button-color text-color border border-[#E1E7EF] px-4 items-center justify-center gap-2 rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors py-1 self-center">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Clear Filters Button - Tablet and Desktop -->
                <button onclick="resetFilters()" id="searchBtn"
                    class="hidden md:flex lg:w-auto lg:px-4 xl:flex-initial items-center justify-center font-heading text-sm rounded-[50px] w-full px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0] nline-flex hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0] ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            d="m15.5 15.5l-10-10zm0-10l-10 10" stroke-width="1" />
                    </svg>
                    <span id="searchBtnText">Clear Filters</span>
                </button>
            </div>

            <!-- Mobile Clear Filters Button -->

            <button onclick="resetFilters()" id="searchBtnMobile"
                class="w-full mt-4 text-sm font-medium bg-white text-gray-900 border border-gray-300 px-6 h-[55px] rounded-full hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-colors md:hidden flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="m15.5 15.5l-10-10zm0-10l-10 10" stroke-width="1" />
                </svg>
                <span id="searchBtnTextMobile">Clear Filters</span>
            </button>
        </div>
    </div>
</div>
<!-- Filter Section End -->

<!-- Filtered Results Section -->
<div id="filtered-results" class="hidden py-4 md:py-8 px-4 sm:px-6 md:px-12 lg:px-20">
    <div class="max-w-8xl mx-auto">
        <!-- Results Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl md:text-2xl font-heading font-bold text-color" id="resultsHeader">
                Found 0 Hostels
            </h1>
            <div id="filteredCarouselButtons" class="flex gap-2 hidden">
                <button onclick="prevFilteredCard()"
                    class="w-10 h-10 rounded-full bg-white border border-color box-shadow flex items-center justify-center hover:bg-[#e3e8f3]/40 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                    </svg>
                </button>
                <button onclick="nextFilteredCard()"
                    class="w-10 h-10 rounded-full bg-white border border-color box-shadow flex items-center justify-center hover:bg-[#e3e8f3]/40 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel Container -->
        <div class="relative overflow-hidden">
            <div id="filteredCarousel"
                class="flex transition-transform duration-500 ease-in-out gap-4 overflow-x-hidden">
                <!-- Results will be populated dynamically by JavaScript -->
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResultsMessage" class="hidden text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-heading font-bold text-gray-700 mb-2">No hostels found</h3>
            <p class="text-gray-600">Try adjusting your filters to see more results</p>
        </div>
    </div>
</div>
<!-- Filtered Results Section End -->

<!-- Top Ranked Hostels Section -->
<div class="py-4 md:py-8 px-4 sm:px-6 md:px-12 lg:px-20 mt-[70px]">
    <div class="max-w-8xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl md:text-2xl font-heading font-bold text-color">Top Rank Hostels</h1>
            <div class="flex gap-2">
                <button onclick="prevCard()"
                    class="w-10 h-10 rounded-full bg-white border border-color box-shadow flex items-center justify-center hover:bg-[#e3e8f3]/40 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                    </svg>
                </button>
                <button onclick="nextCard()"
                    class="w-10 h-10 rounded-full bg-white border border-color box-shadow flex items-center justify-center hover:bg-[#e3e8f3]/40 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                    </svg>
                </button>

            </div>
        </div>

        <!-- Carousel Container -->
        <div class="relative overflow-hidden">
            <div id="carousel" class="flex transition-transform duration-500 ease-in-out gap-4">
                <!-- Card 1 -->
                @foreach ($hostels as $hostel)
                <div class="flex-none w-full md:w-[calc(50%-8px)] xl:w-[calc(33.333%-11px)] 2xl:w-[calc(25%-12px)]">
                    <div class="bg-white rounded-[20px] border border-color box-shadow  overflow-hidden">
                        <!-- Image Slider -->
                        <div class="relative">
                            <div class="image-slider">
                                <div class="image-slides flex transition-transform duration-300">
                                    @foreach ($hostel->images as $img)
                                    <img src="{{ asset('storage/images/hostelImages/' . $img->image) }}"
                                        alt="{{ $hostel->name }}" class="w-full h-48 object-cover flex-none">
                                    @endforeach
                                </div>
                                @if (count($hostel->images) > 1)
                                <button
                                    class="absolute left-2 top-2/3 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-100"
                                    onclick="changeImage(this, -1)">
                                    <i class="fas fa-chevron-left text-sm text-gray-700"></i>
                                </button>
                                <button
                                    class="absolute right-2 top-2/3 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-100"
                                    onclick="changeImage(this, 1)">
                                    <i class="fas fa-chevron-right text-sm text-gray-700"></i>
                                </button>
                                <div class="absolute bottom-3 left-1/2 ml-3 -translate-x-1/2 flex gap-1">
                                    @foreach ($hostel->images as $index => $img)
                                    <span
                                        class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white dot active' : 'bg-white/50 dot' }}"></span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-base font-medium font-heading text-color opacity-80">
                                    {{ $hostel->name }}
                                </h3>
                                <div class="flex items-center gap-1 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#FACC15]" width="20"
                                        height="20" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M21.12 9.88a.74.74 0 0 0-.6-.51l-5.42-.79l-2.43-4.91a.78.78 0 0 0-1.34 0L8.9 8.58l-5.42.79a.74.74 0 0 0-.6.51a.75.75 0 0 0 .18.77L7 14.47l-.93 5.4a.76.76 0 0 0 .3.74a.75.75 0 0 0 .79.05L12 18.11l4.85 2.55a.73.73 0 0 0 .35.09a.8.8 0 0 0 .44-.14a.76.76 0 0 0 .3-.74l-.94-5.4l3.93-3.82a.75.75 0 0 0 .19-.77" />
                                    </svg>
                                    @if ($hostel->average_rating > 0)
                                    <span
                                        class="font-medium font-heading text-base text-color">{{ number_format($hostel->average_rating, 1) }}</span>
                                    <span class="sub-text font-heading text-sm">({{ $hostel->review_count }})</span>
                                    @else
                                    <span class="font-medium font-heading text-base text-gray-400">No
                                        ratings</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-[#E4EAFD]" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M7 17H4C2.38 17 .96 15.74.76 14.14l-.5-2.99C.15 10.3.39 9.5.91 8.92S2.19 8 3 8h6c.83 0 1.58.35 2.06.96c.11.15.21.31.29.49c.43-.09.87-.09 1.29 0c.08-.18.18-.34.3-.49C13.41 8.35 14.16 8 15 8h6c.81 0 1.57.34 2.09.92c.51.58.75 1.38.65 2.19l-.51 3.07C23.04 15.74 21.61 17 20 17h-3c-1.56 0-3.08-1.19-3.46-2.7l-.9-2.71c-.38-.28-.91-.28-1.29 0l-.92 2.78C10.07 15.82 8.56 17 7 17" />
                                </svg>
                                <span class="font-regular text-xs font-heading text-color">{{ $hostel->type }}
                                    Hostel</span>
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
                                    <span class="truncate max-w-[100px]">{{ $amenity->amenity_name }}</span>
                                </div>
                                @endforeach
                            </div>
                            <!-- Price -->
                            <div class="flex items-end justify-between border-t border-gray-200">
                                @php
                                $lowestRent = $hostel->blocks
                                ->flatMap(fn($block) => $block->occupancies)
                                ->min('monthly_rent');
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
                                {{-- --}}
                                <a href="{{ route('hostelDetail', $hostel->slug) }}">
                                    <button
                                        class="px-5 py-2 button-color border borer-color text-color rounded-full font-heading font-medium hover:bg-[#01217f] hover:text-white transition text-xs">View
                                        Details
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Top Ranked Hostels Section end -->

<!-- Mid Section start -->
<section class="relative py-12 md:py-20 lg:mt-[70px] bg-[#f2f6fa]">
    <!-- Content Container -->
    <div class="w-full px-4 sm:px-6 md:px-12 lg:px-20 relative">
        <!-- Welcome Text -->
        <p class="text-[#8B9BAC] font-heading text-sm md:text-base mb-4 md:mb-6">
            Welcome to {{ $systemConfigs['site_name'] ?? 'HostelHub' }}
        </p>

        <!-- Two Column Layout -->
        <div class="flex flex-col lg:flex-row justify-between gap-8 lg:gap-10 mb-12 md:mb-16">
            <!-- Left Column - Main Heading -->
            <div class="lg:w-1/2">
                <h2 class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-heading font-bold leading-tight">
                    <span class="text-[#1A1A1A]">
                        {{ $systemConfigs['background_title'] ?? "We're here to help you take control of your money and turn" }}
                    </span>
                </h2>
            </div>

            <!-- Right Column - Mission Text & Features -->
            <div class="lg:w-1/2">
                <p class="text-body font-heading text-justify font-regular text-base md:text-lg !leading-[30px] mb-6">
                    {{ $systemConfigs['background_description']}}
                </p>
            </div>
        </div>

        <!-- Hero Image -->
        @if (isset($systemConfigs['background_image']) && $systemConfigs['background_image'])
        <div class="w-full">
            <img src="{{ asset('storage/images/adminConfigImages/' . $systemConfigs['background_image']) }}"
                alt="Happy residents using HostelHub"
                class="w-full h-auto rounded-3xl shadow-2xl object-cover max-h-[600px]">
        </div>
        @endif
    </div>
</section>
<!-- Mid Section end -->

<!-- Recommendation hostels start -->
<div class="bg-gray-50 p-4 md:p-8 px-4 sm:px-6 md:px-12 lg:px-20">
    <div class="max-w-8xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl md:text-2xl font-heading font-bold text-color">Recommendation Hostels</h1>
            <div class="flex gap-2">
                <button id="prevBtn"
                    class="p-2 rounded-full bg-white border border-color box-shadow hover:bg-[#e3e8f3]/40 transition disabled:opacity-50 disabled:cursor-not-allowed pointer-events-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                    </svg>
                </button>
                <button id="nextBtn"
                    class="p-2 rounded-full bg-white border border-color box-shadow hover:bg-[#e3e8f3]/40 transition disabled:opacity-50 disabled:cursor-not-allowed pointer-events-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" stroke-width="1.5" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Slider Container -->
        <div class="relative overflow-hidden z-10">
            <div id="sliderContainer" class="slider-container flex gap-5 overflow-x-hidden">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const hostelsData = @json($hostelsData);
        console.log('Recommendation Hostels Data:', hostelsData);
        console.log('Data type:', typeof hostelsData);
        console.log('Is array:', Array.isArray(hostelsData));

        class CardSlider {
            constructor(cardElement, images, cardIndex) {
                this.cardElement = cardElement;
                this.images = images;
                this.cardIndex = cardIndex;
                this.currentIndex = 0;
                this.autoSlideInterval = null;
                this.isTransitioning = false;
                this.init();
            }

            init() {
                const dots = this.cardElement.querySelectorAll('.dot');
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.goToSlide(index);
                    });
                });

                // Auto-slide disabled
                // this.startAutoSlide();
                // this.cardElement.addEventListener('mouseenter', () => this.stopAutoSlide());
                // this.cardElement.addEventListener('mouseleave', () => this.startAutoSlide());
            }

            updateImage() {
                if (this.isTransitioning) return;
                this.isTransitioning = true;

                const img = this.cardElement.querySelector('.card-image');
                const dots = this.cardElement.querySelectorAll('.dot');

                img.style.opacity = '0';

                setTimeout(() => {
                    img.src = this.images[this.currentIndex];
                    img.style.opacity = '1';
                    this.isTransitioning = false;
                }, 200);

                dots.forEach((dot, index) => {
                    if (index === this.currentIndex) {
                        dot.classList.remove('bg-white/60', 'w-2');
                        dot.classList.add('bg-white', 'w-8');
                    } else {
                        dot.classList.remove('bg-white', 'w-8');
                        dot.classList.add('bg-white/60', 'w-2');
                    }
                });
            }

            goToSlide(index) {
                this.currentIndex = index;
                this.updateImage();
                // Auto-slide disabled
            }

            nextSlide() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
                this.updateImage();
            }

            startAutoSlide() {
                // Auto-slide disabled for card images
            }

            stopAutoSlide() {
                if (this.autoSlideInterval) {
                    clearInterval(this.autoSlideInterval);
                    this.autoSlideInterval = null;
                }
            }

            destroy() {
                this.stopAutoSlide();
            }
        }

        function createCard(hostel, index) {
            return `
                    <div class="flex-shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(25%-18px)] bg-white rounded-[20px] border border-color box-shadow overflow-hidden  hostel-card" data-card="${index}">
                        <div class="relative group">
                        <!-- black overlay -->
                        <div class="absolute inset-0 bg-black/35 z-10 "></div>
                            <span class="absolute top-4 right-4 bg-white text-color text-xs px-4 py-1.5 rounded-sm font-medium z-10 shadow-md">
                                ${hostel.type}
                            </span>
                            <div class="relative h-64 overflow-hidden">
                                <img src="${hostel.images[0]}" alt="${hostel.name}"
                                    class="card-image w-full h-full object-cover transition-opacity duration-200 opacity-100">
                            </div>
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-10">
                                ${hostel.images.map((_, imgIndex) => `
                                                                                                                                                        <button class="dot h-2 ${imgIndex === 0 ? 'w-8 bg-white' : 'w-2 bg-white/60'} rounded-full transition-all duration-300 cursor-pointer hover:bg-white pointer-events-auto"
                                                                                                                                                                data-card="${index}" data-dot="${imgIndex}"></button>
                                                                                                                                                    `).join('')}
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="text-base font-medium font-heading text-color opacity-80 mb-3">${hostel.name}</h3>
                            <div class="flex items-center gap-1 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-[#FACC15]" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M13.51 3.139c-.652-1.185-2.368-1.185-3.021 0a28 28 0 0 0-2.114 4.894a.35.35 0 0 1-.33.223a30 30 0 0 0-4.375.436c-1.337.233-1.926 1.837-.91 2.83q.192.188.388.374a32 32 0 0 0 3.103 2.587a.274.274 0 0 1 .11.31a27.6 27.6 0 0 0-1.172 5.065c-.19 1.424 1.318 2.298 2.495 1.694a29.3 29.3 0 0 0 4.085-2.537a.4.4 0 0 1 .462 0a29 29 0 0 0 4.085 2.537c1.177.604 2.685-.27 2.495-1.694a27.6 27.6 0 0 0-1.171-5.065a.274.274 0 0 1 .11-.31a32 32 0 0 0 3.49-2.96c1.016-.994.427-2.598-.91-2.831a30 30 0 0 0-4.376-.436a.35.35 0 0 1-.329-.223a27.7 27.7 0 0 0-2.114-4.894" />
                                        </svg>
                                <span class="text-base font-bold text-color font-heading">${hostel.rating > 0 ? hostel.rating : 'N/A'}</span>
                                <span class="text-sm sub-text font-heading">(${hostel.reviews})</span>
                                <span class="text-sm font-heading sub-text font-regular">${
                                    hostel.rating >= 4.5 ? 'Excellent Rating' :
                                    hostel.rating >= 4.0 ? 'Very Good Rating' :
                                    hostel.rating >= 3.5 ? 'Good Rating' :
                                    hostel.rating >= 3.0 ? 'Average Rating' :
                                    hostel.rating > 0 ? 'Below Average' :
                                    'No Rating Yet'
                                }</span>
                            </div>

                            <div class="flex items-end justify-between border-t border-color">
                                <div>
                                    <p class="text-sm font-heading sub-text mb-0.5 mt-2">From</p>
                                    <p class="text-lg font-bold font-heading text-color">
                                        NPR ${hostel.price.toLocaleString()}
                                        <span class="text-sm font-normal sub-text font-regular">per month</span>
                                    </p>
                                </div>
                            <a href="/hostel-system/hostel-detail/${hostel.slug}">
                                <button class="px-5 py-2 button-color border borer-color text-color rounded-full font-heading font-medium hover:bg-[#01217f] hover:text-white transition text-xs pointer-events-auto">View Details</button>
                            </a>
                            </div>
                        </div>
                    </div>
                `;
        }

        let sliders = [];
        let sliderContainer;
        let prevBtn;
        let nextBtn;
        let currentSlide = 0;
        let autoSlideInterval = null;

        function initializeCards() {
            console.log('Initializing cards with data:', hostelsData);

            // Check if hostelsData exists and has content
            if (!hostelsData || hostelsData.length === 0) {
                console.error('No hostels data available');
                sliderContainer.innerHTML = '<div class="text-center py-8 text-gray-500">No hostels available</div>';
                return;
            }

            // Clear existing content and sliders
            sliderContainer.innerHTML = '';
            sliders.forEach(slider => slider.destroy());
            sliders = [];

            // Create and append cards one by one
            hostelsData.forEach((hostel, index) => {
                console.log(`Creating card ${index}:`, hostel);

                const cardHtml = createCard(hostel, index);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = cardHtml;
                sliderContainer.appendChild(tempDiv.firstElementChild);
            });


            // Initialize individual card sliders
            document.querySelectorAll('.hostel-card').forEach((cardElement, index) => {
                sliders.push(new CardSlider(cardElement, hostelsData[index].images, index));
            });

            // Force a reflow to ensure proper layout
            sliderContainer.offsetHeight;
        }

        function getCardWidth() {
            const card = document.querySelector('.hostel-card');
            if (!card) return 0;
            return card.offsetWidth + 24;
        }

        function getCardsPerView() {
            const width = window.innerWidth;
            if (width >= 1024) return 4;
            if (width >= 640) return 2;
            return 1;
        }

        function updateButtonStates() {
            const cardsPerView = getCardsPerView();
            const maxSlide = Math.max(0, hostelsData.length - cardsPerView);

            prevBtn.disabled = currentSlide <= 0;
            nextBtn.disabled = currentSlide >= maxSlide;

            // Update button styles based on disabled state
            [prevBtn, nextBtn].forEach(btn => {
                if (btn.disabled) {
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        }

        function goToSlide(slideIndex) {
            const cardsPerView = getCardsPerView();
            const maxSlide = Math.max(0, hostelsData.length - cardsPerView);
            currentSlide = Math.max(0, Math.min(slideIndex, maxSlide));

            const cardWidth = getCardWidth();
            sliderContainer.scrollTo({
                left: currentSlide * cardWidth,
                behavior: 'smooth'
            });

            updateButtonStates();
        }

        function nextSlide() {
            if (nextBtn.disabled) {
                // If we're at the end, loop to the beginning
                currentSlide = 0;
            } else {
                currentSlide++;
            }
            goToSlide(currentSlide);
        }

        function prevSlide() {
            if (prevBtn.disabled) {
                // If we're at the beginning, loop to the end
                const cardsPerView = getCardsPerView();
                currentSlide = Math.max(0, hostelsData.length - cardsPerView);
            } else {
                currentSlide--;
            }
            goToSlide(currentSlide);
        }

        // Add keyboard event listener for controls
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey) {
                switch (e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        prevSlide();
                        stopAutoSlide();
                        startAutoSlide();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        nextSlide();
                        stopAutoSlide();
                        startAutoSlide();
                        break;
                }
            }
        });

        function startAutoSlide() {
            // Auto-scroll disabled for Top Rank Hostels
        }

        function stopAutoSlide() {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
                autoSlideInterval = null;
            }
        }

        function init() {
            sliderContainer = document.getElementById('sliderContainer');
            prevBtn = document.getElementById('prevBtn');
            nextBtn = document.getElementById('nextBtn');

            if (!sliderContainer || !prevBtn || !nextBtn) {
                console.error('Required elements not found');
                return;
            }

            initializeCards();

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                prevSlide();
                // stopAutoSlide(); // Disabled
                // startAutoSlide(); // Disabled
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                nextSlide();
                // stopAutoSlide(); // Disabled
                // startAutoSlide(); // Disabled
            });

            sliderContainer.addEventListener('scroll', () => {
                const cardWidth = getCardWidth();
                if (cardWidth > 0) {
                    const newSlide = Math.round(sliderContainer.scrollLeft / cardWidth);
                    if (newSlide !== currentSlide) {
                        currentSlide = newSlide;
                        updateButtonStates();
                    }
                }
            });

            sliderContainer.addEventListener('mouseenter', stopAutoSlide);
            sliderContainer.addEventListener('mouseleave', () => {
                // Do nothing - auto-scroll disabled
            });

            window.addEventListener('resize', () => {
                updateButtonStates();
                goToSlide(currentSlide);
            });

            setTimeout(() => {
                updateButtonStates();
                // startAutoSlide(); // Disabled auto-scroll
            }, 100);
        }

        // Initialize immediately
        init();
    })();
</script>

<!-- Recommendation hostels end -->
<div id="hostelListing">

</div>
<!-- Listing start -->
<div class="px-4 md:px-20 mt-[70px]">
    <div class="max-w-8xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Left Side - Why List with us -->
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-color font-heading mb-2">Why List with us?</h2>
                <p class="text-[#646E82] font-heading text-sm tracking-tight mb-6">Join thousands of successful
                    hostel
                    owners
                </p>

                <!-- Features List -->
                <div class="space-y-4">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-sm p-5 box-shadow">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-9 h-9 bg-[#4490D9] rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <g fill="none">
                                        <path
                                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M12 2q.563 0 1.11.061a1 1 0 0 1-.22 1.988a8 8 0 1 0 7.061 7.061a1 1 0 1 1 1.988-.22q.06.547.061 1.11c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m-.032 5.877a1 1 0 0 1-.719 1.217A3.002 3.002 0 0 0 12 15a3 3 0 0 0 2.906-2.25a1 1 0 0 1 1.936.5A5.002 5.002 0 0 1 7 12a5 5 0 0 1 3.75-4.842a1 1 0 0 1 1.218.719m6.536-5.75a1 1 0 0 1 .617.923v1.83h1.829a1 1 0 0 1 .707 1.707L18.12 10.12a1 1 0 0 1-.707.293H15l-1.828 1.829a1 1 0 0 1-1.415-1.415L13.586 9V6.586a1 1 0 0 1 .293-.707l3.535-3.536a1 1 0 0 1 1.09-.217m-1.383 3.337L15.586 7v1.414H17l1.536-1.535h-.415a1 1 0 0 1-1-1z" />
                                    </g>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-medium text-color font-heading mb-1">Massive Reach</h3>
                                <p class="sub-text text-sm font-heading tracking-tight font-regular">Connect with
                                    thousands
                                    of
                                    students and
                                    professionals
                                    actively looking for hostels</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-sm p-5 box-shadow">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-9 h-9 bg-[#4490D9] rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M11 15H6l7-14v8h5l-7 14z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-medium text-color font-heading mb-1">Free Listing</h3>
                                <p class="sub-text text-sm font-heading tracking-tight font-regular">No setup fees,
                                    no
                                    hidden charges. List your property completely free</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-sm p-5 box-shadow">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-9 h-9 bg-[#4490D9] rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M9.034 5.963L6.491 8.5c-.467.466-.896.893-1.235 1.28a6 6 0 0 0-.619.82l-.024-.025l-.095-.094a4.9 4.9 0 0 0-1.532-1.004l-.123-.05l-.379-.15a.764.764 0 0 1-.259-1.252C3.345 6.907 4.69 5.566 5.34 5.297a3.4 3.4 0 0 1 1.788-.229c.546.081 1.063.362 1.907.895m4.342 13.35c.205.208.34.355.464.512q.243.311.434.658c.142.26.253.537.474 1.092a.69.69 0 0 0 1.126.224l.084-.083c1.12-1.117 2.465-2.458 2.735-3.105a3.35 3.35 0 0 0 .229-1.782c-.081-.545-.362-1.06-.897-1.902l-2.552 2.544c-.478.477-.916.914-1.313 1.256c-.237.206-.497.41-.784.586" />
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="m14.447 16.377l5.847-5.83c.842-.839 1.263-1.259 1.484-1.792S22 7.627 22 6.44v-.567c0-1.826 0-2.739-.569-3.306S19.947 2 18.116 2h-.57c-1.19 0-1.785 0-2.32.221c-.536.221-.957.641-1.8 1.48L7.58 9.531c-.984.98-1.594 1.589-1.83 2.176a1.5 1.5 0 0 0-.112.562c0 .802.647 1.448 1.942 2.739l.174.173l2.038-2.069a.75.75 0 1 1 1.069 1.053L8.816 16.24l.137.137c1.295 1.29 1.943 1.936 2.747 1.936c.178 0 .348-.031.519-.094c.603-.222 1.219-.836 2.228-1.842m2.747-6.846a1.946 1.946 0 0 1-2.747 0a1.93 1.93 0 0 1 0-2.738a1.946 1.946 0 0 1 2.747 0a1.93 1.93 0 0 1 0 2.738"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-medium text-color font-heading mb-1">Quick Approval</h3>
                                <p class="sub-text text-sm font-heading tracking-tight font-regular">Get your
                                    listing
                                    reviewed and published within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-sm p-5 box-shadow">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-9 h-9 bg-[#4490D9] rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                    viewBox="0 0 24 24"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M14 15h-4v-2H2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6h-8zm6-9h-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v4h20V8a2 2 0 0 0-2-2m-4 0H8V4h8z" />
                                    </svg>
                                    <path fill="currentColor"
                                        d="M14 15h-4v-2H2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6h-8zm6-9h-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v4h20V8a2 2 0 0 0-2-2m-4 0H8V4h8z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-medium text-color font-heading mb-1">Full Control</h3>
                                <p class="sub-text text-sm font-heading tracking-tight font-regular">Manage your
                                    listing, update details, and respond to inquiries anytime</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="bg-white rounded-sm p-4 mt-3.5 box-shadow text-center">
                    <h4 class="text-2xl md:text-3xl font-bold text-color mb-1 font-heading">
                        {{ $systemConfigs['active_monthly_users'] ?? '0' }} +
                    </h4>
                    <p class="sub-text font-heading text-sm">Active monthly users searching for hostels</p>
                </div>
            </div>

            <!-- Right Side - Property Details Form -->
            <div>
                <div class="bg-white rounded-lg box-shadow p-6 md:p-8">
                    <h2 class="text-xl md:text-2xl font-bold text-color mb-2">Property Details</h2>
                    <p class="sub-text font-heading font-regular text-sm mb-6">Fill in your hostel information below
                    </p>

                    <form id="property-form" action="{{ route('propertyListSubmit') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <!-- Row 1: Hostel Name & Owner Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">Hostel Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="e.g Sunshine Hostel" name="hostel_name" id="hostel_name"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('hostel_name')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">Owner Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="e.g John Doe" name="owner_name" id="owner_name"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('owner_name')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Email & Contact Number -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">Email
                                    Address
                                    <span class="text-red-500">*</span></label>
                                <input type="email" placeholder="e.g example@example.com" name="hostel_email"
                                    id="hostel_email"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('hostel_email')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">Contact
                                    Number
                                    <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Your contact number" name="hostel_contact"
                                    id="hostel_contact"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('hostel_contact')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: City & Address -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">City
                                    <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="e.g. Kathmandu" name="hostel_city" id="hostel_city"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('hostel_city')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-base font-heading font-medium text-color mb-2">Address
                                    <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="e.g. New Baneshwor" name="hostel_location"
                                    id="hostel_location"
                                    class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                                @error('hostel_location')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="flex items-center justify-center font-heading text-sm rounded-[50px] ml-left  px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0] nline-flex hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0]">
                                Submit Your Listing
                            </button>
                        </div>
                    </form>
                    @if ($errors->any())
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const formEl = document.getElementById('property-form');
                            if (formEl) {
                                formEl.scrollIntoView({
                                    behavior: 'smooth'
                                });
                            }
                        });
                    </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Listing End -->

<!-- Reviews Section start -->
<section id="reviews-section" class=" bg-[#E6ECFF]/15 py-12 md:py-16 mt-[70px]">
    <div class=" container mx-auto px-4 md:px-8 lg:px-20 max-w-[1920px]">
        <!-- Section Header -->
        <div class="mb-5">
            <h2 class="text-2xl md:text-2xl font-bold text-color font-heading tracking-tight">Hear From Our Happy
                Learners</h2>
        </div>

        <!-- Reviews Grid -->
        <div id="testimonials-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Review Card 1 -->
            @foreach ($testimonials as $testimonial)
            <div class="bg-white rounded-lg border border-[#E1DFDF] p-6">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full overflow-hidden bg-[#F5F5F5]">
                            <img src="{{ asset('storage/images/testimonialImages/' . $testimonial->person_image) }}"
                                alt="{{ $testimonial->person_name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-color font-heading">
                                {{ $testimonial->person_name }}
                            </h3>
                            <p class="text-xs sub-text font-regular mt-1 font-heading">
                                {{ \Carbon\Carbon::parse($testimonial->created_at)->format('d M Y') }}
                                {{-- March 15, 2024 --}}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <span class="sub-text font-medium font-heading text-sm">{{ $testimonial->rating }}</span>
                            <span class="sub-text font-medium font-heading text-sm"> /5</span>
                        </div>
                        <svg class="w-5 h-5 text-[#8BC34A] ml-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z" />
                        </svg>
                    </div>
                </div>
                <p class="text-body font-regular tracking-tight font-heading text-sm leading-6 mb-3 text-justify">
                    {{ strip_tags($testimonial->person_statement) }}
                </p>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div id="testimonials-pagination">
            @if ($testimonials->hasPages())
            <div class="flex justify-center items-center gap-2 mt-8">
                {{-- Previous Page --}}
                @if ($testimonials->onFirstPage())
                <span
                    class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
                @else
                <a href="#" data-page="{{ $testimonials->currentPage() - 1 }}"
                    class="pagination-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($testimonials->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
                @if ($page == $testimonials->currentPage())
                <span
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-[#4490D9] text-white font-medium text-sm">
                    {{ $page }}
                </span>
                @else
                <a href="#" data-page="{{ $page }}"
                    class="pagination-link w-8 h-8 flex items-center justify-center rounded-full sub-text hover:bg-[#e3e8f3] font-medium text-sm">
                    {{ $page }}
                </a>
                @endif
                @endforeach

                {{-- Next Page --}}
                @if ($testimonials->hasMorePages())
                <a href="#" data-page="{{ $testimonials->currentPage() + 1 }}"
                    class="pagination-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                @else
                <span
                    class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Reviews Section end -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to build testimonial HTML
        function buildTestimonialHTML(testimonials) {
            return testimonials.map(testimonial => `
                    <div class="bg-white rounded-lg border border-[#E1DFDF] p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-[#F5F5F5]">
                                    <img src="${testimonial.person_image}"
                                        alt="${testimonial.person_name}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-color font-heading">${testimonial.person_name}</h3>
                                    <p class="text-xs sub-text font-regular mt-1 font-heading">${testimonial.created_at}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <span class="sub-text font-medium font-heading text-sm">${testimonial.rating}</span>
                                    <span class="sub-text font-medium font-heading text-sm"> /5</span>
                                </div>
                                <svg class="w-5 h-5 text-[#8BC34A] ml-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-body font-regular tracking-tight font-heading text-sm leading-6 mb-3 text-justify">
                            ${testimonial.person_statement}
                        </p>
                    </div>
                `).join('');
        }

        // Function to build pagination HTML
        function buildPaginationHTML(pagination) {
            if (pagination.last_page <= 1) {
                return '';
            }

            let html = '<div class="flex justify-center items-center gap-2 mt-8">';

            // Previous button
            if (pagination.on_first_page) {
                html += `<span class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-300 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>`;
            } else {
                html += `<a href="#" data-page="${pagination.current_page - 1}" class="pagination-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>`;
            }

            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                if (i === pagination.current_page) {
                    html +=
                        `<span class="w-8 h-8 flex items-center justify-center rounded-full bg-[#4490D9] text-white font-medium text-sm">${i}</span>`;
                } else {
                    html +=
                        `<a href="#" data-page="${i}" class="pagination-link w-8 h-8 flex items-center justify-center rounded-full sub-text hover:bg-[#e3e8f3] font-medium text-sm">${i}</a>`;
                }
            }

            // Next button
            if (pagination.has_more_pages) {
                html += `<a href="#" data-page="${pagination.current_page + 1}" class="pagination-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>`;
            } else {
                html += `<span class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-300 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>`;
            }

            html += '</div>';
            return html;
        }

        // Handle pagination click
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination-link')) {
                e.preventDefault();

                const link = e.target.closest('.pagination-link');
                const page = link.getAttribute('data-page');

                // Get the position of the reviews section
                const reviewsSection = document.getElementById('reviews-section');
                const sectionTop = reviewsSection.offsetTop;

                // Fetch testimonials for the clicked page
                fetch(`{{ route('testimonials.paginate') }}?page=${page}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update content with built HTML
                        document.getElementById('testimonials-grid').innerHTML =
                            buildTestimonialHTML(data.testimonials);
                        document.getElementById('testimonials-pagination').innerHTML =
                            buildPaginationHTML(data.pagination);

                        // Scroll to reviews section smoothly
                        window.scrollTo({
                            top: sectionTop - 100, // 100px offset from top
                            behavior: 'smooth'
                        });
                    })
                    .catch(error => {
                        console.error('Error loading testimonials:', error);
                    });
            }
        });
    });

    // Filter functionality with vanilla JavaScript
    // Filter state
    const filterState = {
        roomType: '',
        roomTypeLabel: 'Select Room Type',
        gender: '',
        genderLabel: 'Select Gender',
        minPrice: '',
        maxPrice: '',
        priceLabel: 'Select Price Range',
        rating: '',
        ratingLabel: 'Select Rating',
        amenities: []
    };

    // Reset all filters
    function resetFilters() {
        // Reset filter state
        filterState.roomType = '';
        filterState.roomTypeLabel = 'Select Room Type';
        filterState.gender = '';
        filterState.genderLabel = 'Select Gender';
        filterState.minPrice = '';
        filterState.maxPrice = '';
        filterState.priceLabel = 'Select Price Range';
        filterState.rating = '';
        filterState.ratingLabel = 'Select Rating';
        filterState.amenities = [];

        // Update UI labels
        document.getElementById('roomTypeLabel').textContent = 'Select Room Type';
        document.getElementById('genderLabel').textContent = 'Select Gender';
        document.getElementById('priceLabel').textContent = 'Select Price Range';
        document.getElementById('ratingLabel').textContent = 'Select Rating';

        // Uncheck all amenity checkboxes
        const checkboxes = document.querySelectorAll('.amenity-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updateAmenityCount();

        // Hide filtered results section
        const filteredResults = document.getElementById('filtered-results');
        if (filteredResults) {
            filteredResults.classList.add('hidden');
        }
    }

    // Toggle dropdown visibility
    function toggleDropdown(type) {
        const dropdown = document.getElementById(type + 'Dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
        // Close other dropdowns
        ['roomType', 'gender', 'price', 'rating'].forEach(dt => {
            if (dt !== type) {
                const otherDropdown = document.getElementById(dt + 'Dropdown');
                if (otherDropdown && !otherDropdown.classList.contains('hidden')) {
                    otherDropdown.classList.add('hidden');
                }
            }
        });
    }

    // Room Type selection
    function selectRoomType(type) {
        if (type === 'All') {
            filterState.roomType = '';
            filterState.roomTypeLabel = 'All';
        } else {
            filterState.roomType = type;
            filterState.roomTypeLabel = type;
        }
        document.getElementById('roomTypeLabel').textContent = filterState.roomTypeLabel;
        document.getElementById('roomTypeDropdown').classList.add('hidden');
        // Auto-search when room type is selected
        searchHostels();
    }

    // Gender selection
    function selectGender(value, label) {
        filterState.gender = value;
        filterState.genderLabel = label;
        document.getElementById('genderLabel').textContent = label;
        document.getElementById('genderDropdown').classList.add('hidden');
        // Auto-search when gender is selected
        searchHostels();
    }

    // Price Range selection
    function selectPriceRange(min, max, label) {
        if (min === 'All' || max === 'All') {
            filterState.minPrice = '';
            filterState.maxPrice = '';
            filterState.priceLabel = 'All';
        } else {
            filterState.minPrice = min;
            filterState.maxPrice = max;
            filterState.priceLabel = label;
        }
        document.getElementById('priceLabel').textContent = filterState.priceLabel;
        document.getElementById('priceDropdown').classList.add('hidden');
        // Auto-search when price range is selected
        searchHostels();
    }

    // Rating selection
    function selectRating(value, label) {
        if (value === 'All') {
            filterState.rating = '';
            filterState.ratingLabel = 'All';
        } else {
            filterState.rating = value;
            filterState.ratingLabel = label;
        }
        document.getElementById('ratingLabel').textContent = filterState.ratingLabel;
        document.getElementById('ratingDropdown').classList.add('hidden');
        // Auto-search when rating is selected
        searchHostels();
    }

    // Amenities Modal functions
    function openAmenitiesModal() {
        document.getElementById('amenitiesModal').classList.remove('hidden');
        // Close any open dropdowns
        ['roomType', 'gender', 'price', 'rating'].forEach(type => {
            const dropdown = document.getElementById(type + 'Dropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    }

    function closeAmenitiesModal() {
        document.getElementById('amenitiesModal').classList.add('hidden');
    }

    function searchAmenities() {
        const searchTerm = document.getElementById('amenitySearch').value.toLowerCase();
        const amenityItems = document.querySelectorAll('.amenity-item');

        amenityItems.forEach(item => {
            const amenityName = item.getAttribute('data-name');
            if (amenityName.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function updateAmenityCount() {
        const checkedBoxes = document.querySelectorAll('.amenity-checkbox:checked');
        const count = checkedBoxes.length;
        const countBadge = document.getElementById('amenitiesCount');

        if (count > 0) {
            countBadge.textContent = count;
            countBadge.style.display = 'inline-flex';
        } else {
            countBadge.style.display = 'none';
        }
    }

    function resetAmenities() {
        const checkboxes = document.querySelectorAll('.amenity-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updateAmenityCount();
    }

    function applyAmenities() {
        const checkedBoxes = document.querySelectorAll('.amenity-checkbox:checked');
        filterState.amenities = Array.from(checkedBoxes).map(cb => cb.value);
        closeAmenitiesModal();
        // Auto-search when amenities are applied
        searchHostels();
    }

    // Main search function
    async function searchHostels() {
        // Show loading state
        const searchBtn = document.getElementById('searchBtn');
        const searchBtnMobile = document.getElementById('searchBtnMobile');
        const searchIcon = document.getElementById('searchIcon');
        const loadingIcon = document.getElementById('loadingIcon');
        const searchBtnText = document.getElementById('searchBtnText');
        const loadingIconMobile = document.getElementById('loadingIconMobile');
        const searchBtnTextMobile = document.getElementById('searchBtnTextMobile');

        // Disable buttons and show loading (only if they exist)
        if (searchBtn) {
            searchBtn.disabled = true;
            if (searchIcon) searchIcon.classList.add('hidden');
            if (loadingIcon) loadingIcon.classList.remove('hidden');
            // if (searchBtnText) searchBtnText.textContent = 'Searching...';
        }
        if (searchBtnMobile) {
            searchBtnMobile.disabled = true;
            if (loadingIconMobile) loadingIconMobile.classList.remove('hidden');
            // if (searchBtnTextMobile) searchBtnTextMobile.textContent = 'Searching...';
        }

        // Build form data
        const formData = new FormData();
        if (filterState.roomType && filterState.roomType !== 'All') formData.append('roomType', filterState.roomType);
        if (filterState.gender) formData.append('gender', filterState.gender);
        if (filterState.minPrice) formData.append('minPrice', filterState.minPrice);
        if (filterState.maxPrice) formData.append('maxPrice', filterState.maxPrice);
        if (filterState.rating) formData.append('rating', filterState.rating);
        if (filterState.amenities.length > 0) {
            filterState.amenities.forEach(amenity => {
                formData.append('amenities[]', amenity);
            });
        }

        console.log('Filter state:', filterState);

        try {
            const response = await fetch("   {{ route('home.filterHostels') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: formData
            });

            const data = await response.json();
            console.log('Filter response:', data);

            // Display results
            displayResults(data.hostels, data.count);

            // Scroll to results
            document.getElementById('filtered-results').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {
            console.error('Error filtering hostels:', error);
            alert('An error occurred while filtering hostels. Please try again.');
        } finally {
            // Reset button state (only if they exist)
            if (searchBtn) {
                searchBtn.disabled = false;
                if (searchIcon) searchIcon.classList.remove('hidden');
                if (loadingIcon) loadingIcon.classList.add('hidden');
                if (searchBtnText) searchBtnText.textContent = 'Clear Filters';
            }
            if (searchBtnMobile) {
                searchBtnMobile.disabled = false;
                if (loadingIconMobile) loadingIconMobile.classList.add('hidden');
                if (searchBtnTextMobile) searchBtnTextMobile.textContent = 'Clear Filters';
            }
        }
    }

    // Display filtered results
    function displayResults(hostels, count) {
        const resultsSection = document.getElementById('filtered-results');
        const resultsHeader = document.getElementById('resultsHeader');

        // Update header
        resultsHeader.textContent = count > 0 ? `Found ${count} Hostels` : 'No Hostels Found';

        // Show results section
        resultsSection.classList.remove('hidden');

        // Get carousel container
        const carouselContainer = document.getElementById('filteredCarousel');

        // Store hostels data globally for carousel navigation
        window.filteredHostelsData = hostels;

        if (count === 0) {
            carouselContainer.parentElement.classList.add('hidden');
            return;
        }

        carouselContainer.parentElement.classList.remove('hidden');

        // Generate hostel cards HTML
        let hostelCardsHTML = '';
        hostels.forEach(hostel => {
            const minPrice = hostel.blocks && hostel.blocks.length > 0 ?
                Math.min(...hostel.blocks.flatMap(b => b.occupancies || []).map(o => o.monthly_rent || 0)) :
                0;

            const firstImage = hostel.images && hostel.images.length > 0 ?
                hostel.images[0].image :
                'default.jpg';

            hostelCardsHTML += `
                    <div class="flex-none w-full md:w-[calc(50%-8px)] xl:w-[calc(33.333%-11px)] 2xl:w-[calc(25%-12px)]">
                        <div class="bg-white rounded-[20px] border border-color box-shadow overflow-hidden flex flex-col h-full min-h-full">
                            <!-- Image -->
                            <div class="relative">
                                <img src="/storage/images/hostelImages/${firstImage}"
                                     alt="${hostel.name}"
                                     class="w-full h-48 object-cover">
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-base font-medium font-heading text-color opacity-80">${hostel.name}</h3>
                                    <div class="flex items-center gap-1 flex-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-[#FACC15]" width="20" height="20" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M21.12 9.88a.74.74 0 0 0-.6-.51l-5.42-.79l-2.43-4.91a.78.78 0 0 0-1.34 0L8.9 8.58l-5.42.79a.74.74 0 0 0-.6.51a.75.75 0 0 0 .18.77L7 14.47l-.93 5.4a.76.76 0 0 0 .3.74a.75.75 0 0 0 .79.05L12 18.11l4.85 2.55a.73.73 0 0 0 .35.09a.8.8 0 0 0 .44-.14a.76.76 0 0 0 .3-.74l-.94-5.4l3.93-3.82a.75.75 0 0 0 .19-.77" />
                                        </svg>
                                        <span class="font-medium font-heading text-base text-color">${hostel.average_rating > 0 ? hostel.average_rating.toFixed(1) : 'N/A'}</span>
                                        ${hostel.average_rating > 0 ? `<span class="sub-text font-heading text-sm">(${hostel.review_count})</span>` : ''}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#E4EAFD]" width="18" height="18" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M7 17H4C2.38 17 .96 15.74.76 14.14l-.5-2.99C.15 10.3.39 9.5.91 8.92S2.19 8 3 8h6c.83 0 1.58.35 2.06.96c.11.15.21.31.29.49c.43-.09.87-.09 1.29 0c.08-.18.18-.34.3-.49C13.41 8.35 14.16 8 15 8h6c.81 0 1.57.34 2.09.92c.51.58.75 1.38.65 2.19l-.51 3.07C23.04 15.74 21.61 17 20 17h-3c-1.56 0-3.08-1.19-3.46-2.7l-.9-2.71c-.38-.28-.91-.28-1.29 0l-.92 2.78C10.07 15.82 8.56 17 7 17" />
                                    </svg>
                                    <span class="font-regular text-xs font-heading text-color">${hostel.type} Hostel</span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-rule="evenodd" d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                                    </svg>
                                    <span class="font-regular text-sm font-heading text-[#444444]">${hostel.location}</span>
                                </div>
                                <!-- Amenities -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    ${(hostel.amenities || []).slice(0, 3).map(amenity => `
                                                                    <div class="flex items-center text-xs text-color font-heading border gap-1 border-color rounded-xs px-3 py-1 bg-white">
                                                                        <img src="/storage/images/icons/${amenity.amenity_icon}"
                                                                             alt="${amenity.amenity_name}"
                                                                             style="width:15px; height:15px; object-fit:cover; border-radius:8px;">
                                                                        <span class="truncate max-w-[100px]">${amenity.amenity_name}</span>
                                                                    </div>
                                                                `).join('')}
                                </div>
                                <!-- Price -->
                                <div class="flex items-end justify-between border-t border-gray-200">
                                    ${minPrice > 0 ? `
                                                                    <div>
                                                                        <p class="text-sm font-heading sub-text mb-0.5 mt-2">From</p>
                                                                        <p class="text-lg font-bold font-heading text-color">
                                                                            <span>NRP ${minPrice.toLocaleString()}</span>
                                                                            <span class="text-sm font-normal sub-text font-regular">/ month</span>
                                                                        </p>
                                                                    </div>
                                                                ` : '<div></div>'}
                                    <a href="/hostel-system/hostel-detail/${hostel.slug}"
                                       class="button-color text-color font-heading text-xs py-3 px-4 rounded-[50px] transition-all duration-300 hover:bg-[#023BE4] hover:text-white border border-[#E1E7EF] mt-2">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        });

        carouselContainer.innerHTML = hostelCardsHTML;

        // Initialize filtered carousel
        window.filteredCarouselIndex = 0;

        // Show/hide carousel buttons based on hostel count and viewport
        const carouselButtons = document.getElementById('filteredCarouselButtons');
        if (carouselButtons) {
            const cardsPerView = getCardsPerView();
            // Only show buttons if there are more hostels than can fit on screen
            if (count > cardsPerView) {
                carouselButtons.classList.remove('hidden');
            } else {
                carouselButtons.classList.add('hidden');
            }
        }
    }

    // Filtered results carousel navigation
    window.nextFilteredCard = function() {
        const carousel = document.getElementById('filteredCarousel');
        if (!carousel || !window.filteredHostelsData) return;

        const cardWidth = carousel.children[0] ? carousel.children[0].offsetWidth + 16 : 0;
        const cardsPerView = getCardsPerView();
        const maxIndex = Math.max(0, window.filteredHostelsData.length - cardsPerView);

        if (window.filteredCarouselIndex < maxIndex) {
            window.filteredCarouselIndex++;
        } else {
            window.filteredCarouselIndex = 0;
        }

        carousel.scrollTo({
            left: window.filteredCarouselIndex * cardWidth,
            behavior: 'smooth'
        });
    };

    window.prevFilteredCard = function() {
        const carousel = document.getElementById('filteredCarousel');
        if (!carousel || !window.filteredHostelsData) return;

        const cardWidth = carousel.children[0] ? carousel.children[0].offsetWidth + 16 : 0;
        const cardsPerView = getCardsPerView();
        const maxIndex = Math.max(0, window.filteredHostelsData.length - cardsPerView);

        if (window.filteredCarouselIndex > 0) {
            window.filteredCarouselIndex--;
        } else {
            window.filteredCarouselIndex = maxIndex;
        }

        carousel.scrollTo({
            left: window.filteredCarouselIndex * cardWidth,
            behavior: 'smooth'
        });
    };

    function getCardsPerView() {
        const width = window.innerWidth;
        if (width >= 1600) return 4; // 2xl breakpoint
        if (width >= 1280) return 3; // xl breakpoint
        if (width >= 768) return 2; // md breakpoint
        return 1;
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const filterSection = document.getElementById('filter-section');
        const amenitiesModal = document.getElementById('amenitiesModal');

        // Don't close if clicking inside filter section or modal
        if (filterSection && !filterSection.contains(event.target) &&
            amenitiesModal && !amenitiesModal.contains(event.target)) {
            // Close all dropdowns
            ['roomType', 'gender', 'price', 'rating'].forEach(type => {
                const dropdown = document.getElementById(type + 'Dropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush