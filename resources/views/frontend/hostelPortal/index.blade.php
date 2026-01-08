@extends('frontend.layouts.hostelPortal')

@section('body')
    <!-- Hero Section start -->
    {{-- @dd(json_decode($sliders)) --}}
    <div x-data="{
        activeSlide: 0,
        slides: {{ json_encode($sliders) }},
        autoplayInterval: null,
        init() {
            this.autoplayInterval = setInterval(() => this.nextSlide(), 10000);
        },
        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        }
    }" class="relative w-full h-[610px] overflow-hidden">
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" x-transition:enter="transition duration-1000 ease-in-out"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition duration-1000 ease-in-out" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0">
                <!-- Background Image -->
                <img :src="slide.image" class="object-cover w-full h-full" alt="Hostel Image">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>

                <!-- Content Container -->
                <div class="absolute inset-0">
                    <!-- Mobile-first centered content -->
                    <div class="h-full flex flex-col justify-center items-center px-4 md:hidden">
                        <div class="text-white text-center max-w-md">
                            <h1 x-text="slide.title" class="text-4xl font-heading leading-16 mb-4"
                                x-transition:enter="transition duration-1000 ease-out delay-200"
                                x-transition:enter-start="opacity-0 transform translate-y-12"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                            </h1>
                            <p x-text="slide.description" class="text-base leading-7"
                                x-transition:enter="transition duration-1000 ease-out delay-700"
                                x-transition:enter-start="opacity-0 transform translate-y-12"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                            </p>
                        </div>
                    </div>

                    <!-- Desktop layout with navigation -->
                    <div class="hidden md:grid grid-cols-[120px_1fr_120px] h-full items-center px-20 lg:px-[120px]">
                        <!-- Left Navigation Button -->
                        <button
                            @click="prevSlide(); clearInterval(autoplayInterval); autoplayInterval = setInterval(() => nextSlide(), 5000)"
                            class="w-11 h-11 flex items-center justify-center bg-black/80 text-white hover:bg-black/90 focus:outline-none transition rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Desktop Text Content -->
                        <div class="flex flex-col justify-center text-white">
                            <div class="max-w-2xl">
                                <h1 x-text="slide.title" class="text-6xl font-heading leading-16 font-bold mb-4 text-left"
                                    x-transition:enter="transition duration-1000 ease-out delay-200"
                                    x-transition:enter-start="opacity-0 transform translate-y-12"
                                    x-transition:enter-end="opacity-100 transform translate-y-0">
                                </h1>
                                <p x-text="slide.description"
                                    class="text-xl font-heading font-medium leading-7 text-left max-w-12xl"
                                    x-transition:enter="transition duration-1000 ease-out delay-700"
                                    x-transition:enter-start="opacity-0 transform translate-y-12"
                                    x-transition:enter-end="opacity-100 transform translate-y-0">
                                </p>
                            </div>
                        </div>

                        <!-- Right Navigation Button -->
                        <button
                            @click="nextSlide(); clearInterval(autoplayInterval); autoplayInterval = setInterval(() => nextSlide(), 5000)"
                            class="w-11 h-11 flex items-center justify-center bg-black/80 text-white hover:bg-black/90 focus:outline-none transition rounded-full justify-self-end">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <!-- Hero Section end -->

    <!-- Main Content Wrapper for Search Functionality -->
    <div x-data="{
        daysOfStay: 1,
        roomType: 'Private',
        priceRange: '5000-15000',
        priceLabel: 'NPR 5,000 - 15,000',
        searching: false,
        searchResults: null,
        showResults: false,
        showBookingModal: false,
        selectedRoom: null,
        bookingForm: {
            name: '',
            permanent_address: '',
            email: '',
            phone: '',
            message: ''
        },
        submittingBooking: false,
        async searchRooms() {
            this.searching = true;
            console.log('Starting search with:', {
                days: this.daysOfStay,
                type: this.roomType,
                price: this.priceRange
            });
            try {
                const params = new URLSearchParams({
                    days_of_stay: this.daysOfStay,
                    room_type: this.roomType,
                    price_range: this.priceRange
                });
                const url = '{{ route('hostel.search-rooms', $hostel->slug) }}?' + params;
                console.log('Fetching:', url);

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }

                const data = await response.json();
                console.log('Received data:', data);

                this.searchResults = data.rooms;
                this.showResults = true;

                console.log('Search results set:', this.searchResults);

                setTimeout(() => {
                    const section = document.getElementById('searchResultsSection');
                    console.log('Scrolling to section:', section);
                    section?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            } catch (error) {
                console.error('Search error:', error);
                alert('An error occurred while searching: ' + error.message);
            } finally {
                this.searching = false;
            }
        },
        clearFilters() {
            this.daysOfStay = 1;
            this.roomType = 'Private';
            this.priceRange = '5000-15000';
            this.priceLabel = 'NPR 5,000 - 15,000';
            this.searchResults = null;
            this.showResults = false;
        },
        openBookingModal(room) {
            this.selectedRoom = room;
            this.showBookingModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeBookingModal() {
            this.showBookingModal = false;
            this.selectedRoom = null;
            this.bookingForm = {
                name: '',
                permanent_address: '',
                email: '',
                phone: '',
                message: ''
            };
            document.body.style.overflow = 'auto';
        },
        async submitBooking() {
            if (!this.bookingForm.name || !this.bookingForm.email || !this.bookingForm.phone) {
                alert('Please fill in all required fields (Name, Email, Phone)');
                return;
            }

            this.submittingBooking = true;
            try {
                const formData = new FormData();
                formData.append('name', this.bookingForm.name);
                formData.append('permanent_address', this.bookingForm.permanent_address);
                formData.append('email', this.bookingForm.email);
                formData.append('phone', this.bookingForm.phone);
                formData.append('message', this.bookingForm.message);
                formData.append('room_id', this.selectedRoom?.id || '');
                formData.append('days_of_stay', this.daysOfStay);
                formData.append('room_type', this.roomType);
                formData.append('price_range', this.priceRange);

                // This will be submitted to your booking store route
                const response = await fetch('{{ route('hostel.bookingStore', $hostel->slug) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your booking request has been submitted successfully. We will contact you soon.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    this.closeBookingModal();
                } else {
                    throw new Error('Failed to submit booking');
                }
            } catch (error) {
                console.error('Booking error:', error);
                alert('An error occurred while submitting your booking. Please try again.');
            } finally {
                this.submittingBooking = false;
            }
        }
    }">

        <!-- Search Card Section Start -->
        <div class="w-full bg-white shadow-custom-combo min-h-[170px] md:h-auto relative -mt-20 z-10" id="searchSection">
            <div class="max-w-[1920px] mx-auto px-4 md:px-8 lg:px-[120px] h-full py-6">
                <div class="h-full flex flex-col justify-center">
                    <div class="border-b-[0.5px] border-[#E1DFDF] pb-4 mb-6">
                        <h2 class="text-[#151515] font-heading text-xl font-bold tracking-tight">
                            Search Rooms for Your Short Term Stay
                        </h2>
                    </div>
                    <div>
                        <div class="flex flex-col md:flex-row gap-4 items-end w-full">
                            <!-- Number of Days Input -->
                            <div class="relative w-full md:w-auto flex-1">
                                <div
                                    class="w-full flex items-center border border-gray-300 rounded-[4px] px-4 h-[55px] bg-[#F7F4F4]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div class="text-left flex-1">
                                        <label for="days_of_stay" class="block text-xs text-gray-500 font-heading">Number of
                                            Days</label>
                                        <input type="number" id="days_of_stay" x-model="daysOfStay" min="1"
                                            placeholder="Enter days"
                                            class="block text-sm font-medium font-heading text-color bg-transparent border-0 focus:ring-0 p-0 w-full">
                                    </div>
                                </div>
                            </div>

                            <!-- Room Type Dropdown -->
                            <div class="relative w-full md:w-auto flex-1" x-data="{ roomTypeOpen: false }">
                                <button type="button" @click="roomTypeOpen = !roomTypeOpen"
                                    class="w-full flex items-center justify-between border border-gray-300 rounded-[4px] px-4 h-[55px] bg-[#F7F4F4] hover:border-gray-400 transition-colors">
                                    <div class="flex items-center flex-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <div class="text-left">
                                            <label class="block text-xs text-gray-500 font-heading">Room Type</label>
                                            <span class="block text-sm font-medium font-heading text-color"
                                                x-text="roomType"></span>
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="roomTypeOpen" @click.away="roomTypeOpen = false"
                                    class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-[4px] shadow-custom-combo z-50">
                                    <div class="py-1">
                                        <a href="#" @click.prevent="roomType = 'Private'; roomTypeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">Private
                                            (Single)</a>
                                        <a href="#" @click.prevent="roomType = 'Shared'; roomTypeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">Shared
                                            (Double/Triple)</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Range Dropdown -->
                            <div class="relative w-full md:w-auto flex-1" x-data="{ priceRangeOpen: false }">
                                <button type="button" @click="priceRangeOpen = !priceRangeOpen"
                                    class="w-full flex items-center justify-between border border-gray-300 rounded-[4px] px-4 h-[55px] bg-[#F7F4F4] hover:border-gray-400 transition-colors">
                                    <div class="flex items-center flex-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="text-left">
                                            <label class="block text-xs text-gray-500">Price Range (Monthly)</label>
                                            <span class="block text-sm font-medium" x-text="priceLabel"></span>
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="priceRangeOpen" @click.away="priceRangeOpen = false"
                                    class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-[4px] shadow-custom-combo z-50">
                                    <div class="py-1">
                                        <a href="#"
                                            @click.prevent="priceRange = '5000-15000'; priceLabel = 'NPR 5,000 - 15,000'; priceRangeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">NPR
                                            5,000 - 15,000</a>
                                        <a href="#"
                                            @click.prevent="priceRange = '15000-25000'; priceLabel = 'NPR 15,000 - 25,000'; priceRangeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">NPR
                                            15,000 - 25,000</a>
                                        <a href="#"
                                            @click.prevent="priceRange = '25000-35000'; priceLabel = 'NPR 25,000 - 35,000'; priceRangeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">NPR
                                            25,000 - 35,000</a>
                                        <a href="#"
                                            @click.prevent="priceRange = '35000-50000'; priceLabel = 'NPR 35,000 - 50,000'; priceRangeOpen = false"
                                            class="block px-4 py-2 text-sm hover:bg-gray-100 font-heading text-color">NPR
                                            35,000 - 50,000</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <button type="button" @click="searchRooms()" :disabled="searching"
                                class="hidden md:flex font-heading text-base font-bold bg-[#00A1A5] text-white px-8 items-center justify-center gap-2 rounded-[50px] hover:bg-[#076166] transition-colors h-[45px] self-center disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg x-show="!searching" xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                                        d="m21 21l-4-4m2-6a8 8 0 1 1-16 0a8 8 0 0 1 16 0" />
                                </svg>
                                <svg x-show="searching" class="animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                                        opacity=".25" />
                                    <path fill="currentColor"
                                        d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                                </svg>
                                <span x-text="searching ? 'Searching...' : 'Search'"></span>
                            </button>

                            <!-- Clear Filter Button -->
                            <button type="button" @click="clearFilters()"
                                class="hidden md:flex font-heading text-base font-bold bg-gray-500 text-white px-8 items-center justify-center gap-2 rounded-[50px] hover:bg-gray-600 transition-colors h-[45px] self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z" />
                                </svg>
                                Clear Filter
                            </button>
                        </div>

                        <!-- Mobile Search Button -->
                        <button type="button" @click="searchRooms()" :disabled="searching"
                            class="w-full mt-4 bg-[#00A1A5] text-white px-6 h-[55px] rounded-lg hover:bg-[#076166] transition-colors md:hidden disabled:opacity-50">
                            <span x-text="searching ? 'Searching...' : 'Search'"></span>
                        </button>
                    </div>

                    <!-- Price Note -->
                    <div class="mt-4 text-xs text-gray-600 font-heading">
                        <p><strong>Note:</strong> Prices shown are monthly rent. The actual cost for your stay will be
                            calculated based on the number of days you stay.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Card Section End -->

        <!-- Search Results Section Start -->
        <div x-show="showResults" x-cloak class="w-full mt-10" id="searchResultsSection">
            <div class="max-w-[1920px] mx-auto px-4 md:px-8 lg:px-[120px]">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <h2 class="text-color font-heading text-xl font-bold tracking-tight">
                        Search Results (<span x-text="searchResults ? searchResults.length : 0"></span> rooms found)
                    </h2>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3.5 h-3.5 rounded-full bg-[#21C45D]"></div>
                            <span class="text-sm text-color tracking-tight font-medium font-heading">Available Rooms</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3.5 h-3.5 rounded-full bg-[#EF4343]"></div>
                            <span class="text-sm text-color tracking-tight font-medium font-heading">Unavailable
                                Rooms</span>
                        </div>
                    </div>
                </div>

                <!-- No Results Message -->
                <div x-show="searchResults && searchResults.length === 0"
                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-yellow-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold text-gray-800 mb-2 font-heading">No Rooms Found</h3>
                    <p class="text-gray-600 font-heading">Try adjusting your search filters to find available rooms.</p>
                </div>

                <!-- Rooms Grid -->
                <div x-show="searchResults && searchResults.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="room in searchResults" :key="room.id">
                        <div
                            class="bg-white rounded-lg border border-[#E1DFDF] overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Room Image -->
                            <div class="relative h-48">
                                <img :src="room.photo_url ||
                                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800'"
                                    :alt="'Room ' + room.room_number" class="w-full h-full object-cover">
                                <!-- Availability Badge -->
                                <div class="absolute top-3 right-3">
                                    <span x-show="room.available_beds > 0"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-[#21C45D] rounded-full">
                                        Available
                                    </span>
                                    <span x-show="room.available_beds === 0"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-[#EF4343] rounded-full">
                                        Full
                                    </span>
                                </div>
                            </div>

                            <!-- Room Details -->
                            <div class="p-5">
                                <!-- Room Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-bold text-color font-heading"
                                        x-text="'Room ' + room.room_number"></h3>
                                    <span class="text-sm text-gray-600 font-heading" x-text="room.block_name"></span>
                                </div>

                                <!-- Room Info -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="font-heading" x-text="room.occupancy_type"></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="font-heading"
                                            x-text="room.available_beds + '/' + room.total_beds + ' beds available'"></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="font-heading" x-text="room.location_name"></span>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <div class="flex items-baseline justify-between">
                                        {{-- <div>
                                            <p class="text-2xl font-bold text-[#00A1A5] font-heading"
                                                x-text="'NPR ' + room.daily_rate.toLocaleString()"></p>
                                            <p class="text-xs text-gray-500 font-heading"
                                                x-text="'for ' + daysOfStay + ' days'"></p>
                                        </div> --}}
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600 font-heading"
                                                x-text="'NPR ' + room.monthly_rent.toLocaleString() + '/month'">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                <button type="button" @click="openBookingModal(room)"
                                    class="block w-full text-center bg-[#00A1A5] hover:bg-[#076166] text-white font-heading font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- Search Results Section End -->

        <!-- Booking Modal -->
        <div x-show="showBookingModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
            @keydown.escape.window="closeBookingModal()">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeBookingModal()"></div>

            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto"
                    @click.away="closeBookingModal()" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-2xl font-bold text-color font-heading">Book Room</h3>
                            <p class="text-sm text-gray-600 mt-1 font-heading" x-show="selectedRoom">
                                Booking <span x-text="selectedRoom?.block_name"></span> Room <span
                                    x-text="selectedRoom?.room_number"></span>
                            </p>
                        </div>
                        <button @click="closeBookingModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form @submit.prevent="submitBooking()" class="space-y-4">
                            <input type="hidden" name="room_id" :value="selectedRoom?.id">
                            <!-- Name -->
                            <div>
                                <label for="booking_name"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-heading">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="booking_name" x-model="bookingForm.name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00A1A5] focus:border-transparent font-heading"
                                    placeholder="Enter your full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="booking_email"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-heading">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="booking_email" x-model="bookingForm.email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00A1A5] focus:border-transparent font-heading"
                                    placeholder="your.email@example.com">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="booking_phone"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-heading">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="booking_phone" x-model="bookingForm.phone" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00A1A5] focus:border-transparent font-heading"
                                    placeholder="+977 98XXXXXXXX">
                            </div>

                            <!-- Permanent Address -->
                            <div>
                                <label for="booking_address"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-heading">
                                    Permanent Address
                                </label>
                                <input type="text" id="booking_address" x-model="bookingForm.permanent_address"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00A1A5] focus:border-transparent font-heading"
                                    placeholder="City, District, Province">
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="booking_message"
                                    class="block text-sm font-medium text-gray-700 mb-1 font-heading">
                                    Message
                                </label>
                                <textarea id="booking_message" x-model="bookingForm.message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00A1A5] focus:border-transparent font-heading resize-none"
                                    placeholder="Any specific requirements or questions..."></textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex gap-3 pt-4">
                                <button type="button" @click="closeBookingModal()"
                                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-heading font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="submittingBooking"
                                    class="flex-1 px-6 py-3 bg-[#00A1A5] text-white font-heading font-semibold rounded-lg hover:bg-[#076166] transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg x-show="submittingBooking" class="animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span x-text="submittingBooking ? 'Submitting...' : 'Book Now'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Booking Modal -->

        <!-- Room Availability Section Start -->
        <div class="w-full mt-10" x-show="!showResults">
            <div class="max-w-[1920px] mx-auto px-4 md:px-8 lg:px-[120px]">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <h2 class="text-color font-heading text-xl font-bold font-heading tracking-tight">Room availability
                    </h2>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class=" w-3.5 h-3.5 rounded-full bg-[#21C45D]"></div>
                            <span class="text-sm text-color tracking-tight font-medium font-heading">Available Rooms</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3.5 h-3.5 rounded-full bg-[#EF4343]"></div>
                            <span class="text-sm text-color tracking-tight font-medium font-heading">Unavailable
                                Rooms</span>
                        </div>
                    </div>
                </div>

                <!-- Blocks Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($blocks as $block)
                        @php
                            $totalRooms = $block->floors->flatMap->rooms->count();
                            $availableRooms = $block->floors->flatMap->rooms
                                ->filter(function ($room) {
                                    return $room->beds->where('status', 'Available')->count() > 0;
                                })
                                ->count();
                        @endphp
                        <!-- Block {{ $block->name }} -->
                        <div class="rounded-[8px] border border-[#E1DFDF] bg-white shadow-custom-combo">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-[#E1DFDF]">
                                <h3 class="text-lg font-bold font-heading tracking-tight text-color">{{ $block->name }}
                                </h3>
                                <span
                                    class="text-sm sub-text font-heading font-regular tracking-tight">{{ $availableRooms }}/{{ $totalRooms }}
                                    Available</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                                @foreach ($block->floors->flatMap->rooms->take(4) as $room)
                                    @php
                                        $availableBeds = $room->beds->where('status', 'Available')->count();
                                        $totalBeds = $room->beds->count();
                                        $isAvailable = $availableBeds > 0;
                                    @endphp
                                    <!-- Room Card -->
                                    <div x-data="{ tooltip: false }" @mouseleave="tooltip = false" class="relative">
                                        <div @mouseenter="tooltip = true"
                                            class="group flex flex-col h-auto bg-white rounded-[4px] p-4 hover:bg-gray-50 transition-colors cursor-pointer border border-[#E1DFDF]">
                                            <!-- Top row with room info -->
                                            <div class="flex items-center justify-between mb-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute -top-1 -right-1 w-3 h-3 rounded-full {{ $isAvailable ? 'bg-[#4ADE80]' : 'bg-[#EF4343]' }}">
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 512 512">
                                                            <path fill="currentColor"
                                                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                                                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="font-heading font-medium text-color">Room
                                                        {{ $room->room_number }}</h4>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="text-sub-text" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" viewBox="0 0 512 512">
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="32"
                                                            d="M384 240H96V136a40.12 40.12 0 0 1 40-40h240a40.12 40.12 0 0 1 40 40v104ZM48 416V304a64.19 64.19 0 0 1 64-64h288a64.19 64.19 0 0 1 64 64v112" />
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="32"
                                                            d="M48 416v-8a24.07 24.07 0 0 1 24-24h368a24.07 24.07 0 0 1 24 24v8M112 240v-16a32.09 32.09 0 0 1 32-32h80a32.09 32.09 0 0 1 32 32v16m0 0v-16a32.09 32.09 0 0 1 32-32h80a32.09 32.09 0 0 1 32 32v16" />
                                                    </svg>
                                                    <span
                                                        class="text-sm sub-text font-heading font-medium">{{ $availableBeds }}/{{ $totalBeds }}</span>
                                                </div>
                                            </div>

                                            <!-- Bottom row with badge and button -->
                                            <div class="flex items-center justify-between">
                                                <span
                                                    class="inline-block text-xs font-regular sub-text bg-[#D9E7E7] px-4 py-1 rounded-[50px] font-heading">
                                                    {{ $room->occupancy ? $room->occupancy->occupancy_type : 'N/A' }}
                                                </span>
                                                <a href="{{ route('hostel.roomDetail', [$hostel->slug, $room->slug]) }}"
                                                    class="px-4 py-1 bg-[#00A1A5] text-white text-xs font-medium rounded-[50px] hover:bg-[#076166] transition-colors">View</a>
                                            </div>
                                        </div>

                                        <!-- Tooltip -->
                                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-1"
                                            class="absolute left-0 top-[calc(100%+0.5rem)] w-[281px] bg-white rounded-[4px] shadow-custom-combo border border-[#E5E7EB] p-4 z-50">
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span
                                                        class="text-sm sub-text font-heading font-regular tracking-tight">Status:</span>
                                                    <span
                                                        class="text-sm font-medium {{ $isAvailable ? 'text-[#21C45D]' : 'text-[#EF4343]' }} font-heading tracking-tight">
                                                        {{ $isAvailable ? 'Available' : 'Unavailable' }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span
                                                        class="text-sm sub-text font-heading font-regular tracking-tight">Room
                                                        Type:</span>
                                                    <span
                                                        class="text-sm font-medium text-color font-heading tracking-tight">
                                                        {{ $room->occupancy ? $room->occupancy->occupancy_type : 'N/A' }}
                                                    </span>
                                                </div>
                                                @if ($room->room_window_number)
                                                    <div class="flex justify-between">
                                                        <span
                                                            class="text-sm text-[#646E82] font-heading font-regular tracking-tight">Window:</span>
                                                        <span
                                                            class="text-sm font-medium text-color font-heading tracking-tight">{{ $room->room_window_number }}</span>
                                                    </div>
                                                @endif
                                                @if ($room->room_size)
                                                    <div class="flex justify-between">
                                                        <span
                                                            class="text-sm text-[#646E82] font-heading font-regular tracking-tight">Room
                                                            size:</span>
                                                        <span
                                                            class="text-sm font-medium text-color font-heading tracking-tight">{{ $room->room_size }}
                                                            sq ft</span>
                                                    </div>
                                                @endif
                                                <div class="flex justify-between">
                                                    <span
                                                        class="text-sm text-[#646E82] font-heading font-regular tracking-tight">Available
                                                        Bed:</span>
                                                    <span
                                                        class="text-sm font-medium text-color font-heading tracking-tight">{{ $availableBeds }}
                                                        of
                                                        {{ $totalBeds }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2">
                            <p class="text-center text-gray-500 py-8">No rooms available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- Room Availability Section End -->

    </div>
    <!-- End Main Content Wrapper for Search Functionality -->

    <!-- About Us Section start -->
    <section class="mt-10 md:mt-10 relative">

        <div class="px-4 md:px-8 lg:px-[120px] max-w-[1920px] mx-auto w-full">
            <!-- Heading with underline -->
            <div class="flex flex-col items-start md:mb-6 mb-6">
                <h2 class="text-2xl md:text-xl font-bold text-color mb-4 font-heading tracking-tight">About Us</h2>
                <!-- Decorative line -->
                <div class="w-full md:w-full h-[0.5px] bg-[#E1DFDF]"></div>

                <!-- Rating Badge -->
                @if ($averageRating > 0)
                    <div
                        class="bg-[#027E83] text-white py-2 md:py-2.5 px-4 md:px-6 rounded-full flex items-center gap-1.5 md:gap-1 shadow-sm mt-6 md:mt-10">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-white fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                        <span class="font-bold text-base md:text-base font-heading tracking-tight">
                            Rated {{ number_format($averageRating, 1) }}
                            @if ($averageRating >= 4.5)
                                Excellent
                            @elseif($averageRating >= 4.0)
                                Very Good
                            @elseif($averageRating >= 3.5)
                                Good
                            @elseif($averageRating >= 3.0)
                                Average
                            @else
                                Below Average
                            @endif
                        </span>
                    </div>
                @else
                    <div
                        class="bg-gray-400 text-white py-2 md:py-2.5 px-4 md:px-6 rounded-full flex items-center gap-1.5 md:gap-1 shadow-sm mt-6 md:mt-10">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-white fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                        <span class="font-bold text-base md:text-base font-heading tracking-tight">
                            No Rating Yet
                        </span>
                    </div>
                @endif
            </div>

            <!-- Main Content -->
            <div class="flex flex-col md:flex-row gap-0 md:gap-12 lg:gap-16">
                <!-- Left Column -->
                <div class="flex-1 space-y-8">
                    @if (isset($hostelConfigs['about_title']))
                        <div>
                            <h3 class="text-2xl md:text-[28px] font-bold text-color mb-3 font-heading tracking-tight">
                                {{ $hostelConfigs['about_title'] }}
                            </h3>
                            <p class="text-body text-justify font-heading tracking-tight leading-6 text-base ">
                                "{{ $hostelConfigs['about_description'] }}"
                            </p>
                        </div>
                    @endif

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-auto">
                        <!-- Prime Location Card -->
                        <div class="flex items-start gap-3 px-6 py-4 border-[0.8px] border-[#E1DFDF] rounded-[4px] h-auto">
                            <div class="bg-[#D9D9D9] p-3 rounded-[4px]">
                                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-base font-medium text-black font-heading tracking-tight">Prime Location
                                </h4>
                                <p class="text-body text-sm font-heading tracking-tight leading-6">Walk distance to
                                    attractions
                                </p>
                            </div>
                        </div>

                        <!-- Vibrant Community Card -->
                        <div class="flex items-start gap-3 px-6 py-4 border-[0.8px] border-[#E1DFDF] rounded-[4px] h-auto">
                            <div class="bg-[#D9D9D9] p-3 rounded-[4px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M8 2a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3M5.5 3.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0M4 8.5q.001-.274.056-.53l-1.944.52a1.5 1.5 0 0 0-1.06 1.838l.388 1.449a3 3 0 0 0 3.773 2.092a4 4 0 0 1-.683-.878a2 2 0 0 1-2.124-1.473l-.389-1.45a.5.5 0 0 1 .354-.612L4 9.02zm6.886 5.398l-.1-.028c.267-.26.498-.555.684-.879a2 2 0 0 0 2.124-1.473l.388-1.45a.5.5 0 0 0-.353-.612L12 9.02V8.5q-.001-.274-.056-.53l1.943.52a1.5 1.5 0 0 1 1.061 1.838l-.388 1.449a3 3 0 0 1-3.674 2.12M2 5a1 1 0 1 1 2 0a1 1 0 0 1-2 0m1-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4m10 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0a2 2 0 0 1-4 0M6.5 7A1.5 1.5 0 0 0 5 8.5V11a3 3 0 1 0 6 0V8.5A1.5 1.5 0 0 0 9.5 7zM6 8.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V11a2 2 0 1 1-4 0z" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-base font-medium text-black font-heading tracking-tight">Vibrant
                                    Community
                                </h4>
                                <p class="text-body text-sm font-heading tracking-tight leading-6">Meet travelers
                                    worldwide
                                </p>
                            </div>
                        </div>

                        <!-- Eco-Friendly Card -->
                        <div class="flex items-start gap-3 px-6 py-4 border-[0.8px] border-[#E1DFDF] rounded-[4px] h-auto">
                            <div class="bg-[#D9D9D9] p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5.4 19.6Q4.275 18.475 3.637 17T3 13.95t.6-3.112T5.55 7.95q.875-.875 2.163-1.5t3.05-.987t4.025-.438t5.062.175q.2 2.65.125 4.875t-.413 4.013t-.95 3.124T17.1 19.45q-1.325 1.325-2.812 1.938T11.25 22q-1.625 0-3.175-.638T5.4 19.6m2.8-.4q.725.425 1.488.613T11.25 20q1.15 0 2.275-.462t2.15-1.488q.45-.45.913-1.263t.8-2.124t.512-3.175t.05-4.438q-1.225-.05-2.762-.037t-3.063.237t-2.9.725t-2.25 1.375q-1.125 1.125-1.55 2.225T5 13.7q0 1.475.563 2.588t.987 1.562q1.05-2 2.775-3.838T13.35 11q-1.8 1.575-3.137 3.563T8.2 19.2m0 0" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-base font-medium text-black font-heading tracking-tight">Eco-Friendly
                                </h4>
                                <p class="text-body text-sm font-heading tracking-tight leading-6">Meet travelers
                                    worldwide
                                </p>
                            </div>
                        </div>

                        <!-- Reviews Card -->
                        <div class="flex items-start gap-3 px-6 py-4 border-[0.8px] border-[#E1DFDF] rounded-[4px] h-auto">
                            <div class="bg-[#D9D9D9] p-3 rounded-[4px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m0 14H5.17L4 17.17V4h16z" />
                                    <path fill="currentColor"
                                        d="m12 15l1.57-3.43L17 10l-3.43-1.57L12 5l-1.57 3.43L7 10l3.43 1.57z" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-base font-medium text-black font-heading tracking-tight">2,847 Reviews
                                </h4>
                                <p class="text-body text-sm font-heading tracking-tight leading-6">Meet travelers
                                    worldwide
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Desktop Button -->
                    <div class="hidden md:block mt-8">
                        <a href="{{ route('about') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#00A1A5] text-white rounded-full hover:bg-[#076166] transition-colors">
                            <span class="text-base font-bold font-heading">Discover More About us</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Room Features Card -->
                <div class="flex-1">
                    <div class="bg-white rounded-[8px] p-8 shadow-custom-combo">
                        <h2 class="text-2xl font-bold text-color mb-8 font-heading tracking-tight">Room Features</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                            <!-- Private Rooms -->
                            {{-- @dd($hostelFeatures) --}}
                            @foreach ($hostelFeatures as $feature)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-[#F5F5F5] rounded-lg flex items-center justify-center">
                                        <img src="{{ asset('storage/images/icons/' . $feature->feature_icon) }}"
                                            alt="{{ $feature->feature_name }}" class="w-6 h-6">
                                    </div>
                                    <span
                                        class="text-base font-regular text-color font-heading">{{ $feature->feature_name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Discover More Button -->
                <div class="mt-8 order-last md:hidden">
                    <a href="{{ route('hostel.aboutUs', $hostel->slug) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-[#00A1A5] text-white rounded-full hover:bg-[#076166] transition-colors">
                        <span class="text-base font-bold font-heading">Discover More About us</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section end -->

    <!-- Location Section start -->
    <section class="mt-10">
        <div class="container mx-auto px-4 md:px-8 lg:px-[120px] max-w-[1920px]">
            <!-- Section Header -->
            <div class="mb-10">
                <h2 class="text-2xl md:text-xl font-bold text-color mb-4 font-heading tracking-tight">Location</h2>
                <div class="w-full h-[0.5px] bg-[#E1DFDF]"></div>
            </div>

            <!-- Two Column Layout -->
            <div class="flex flex-col lg:flex-row gap-3 items-start justify-between">
                <!-- Map Column -->
                <div class="w-full lg:flex-1">
                    <div class="w-full h-[440px] rounded-[8px] overflow-hidden ">
                        @if (isset($hostelConfigs['google_map_embed']))
                            <iframe src="{{ $hostelConfigs['google_map_embed'] }}" width="100%" height="100%"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" class="rounded-lg">
                            </iframe>
                        @endif
                    </div>
                </div>
                <!-- Contact Information Column -->
                <div class="w-full lg:w-[424px]">
                    <!-- Contact Card -->
                    <div class="bg-[#F2F2F2] rounded-lg p-8">
                        <!-- Heading with stroke -->
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-color mb-4 font-heading">Contact Information</h2>
                            <div class="w-full h-[0.7px] bg-[#E1DFDF]"></div>
                        </div>

                        <!-- Contact Details List -->
                        <div class="space-y-6">
                            <!-- Phone Number -->
                            <div>
                                <h3 class="text-base font-medium text-color mb-2 font-heading">Phone No:</h3>
                                @if (isset($hostelConfigs['contact_phone_1']))
                                    <p class="text-body font-heading text-sm">+977 {{ $hostelConfigs['contact_phone_1'] }}
                                        /
                                        {{ $hostelConfigs['contact_phone_2'] }}</p>
                                @endif
                            </div>

                            <!-- Location -->
                            <div>
                                <h3 class="text-base font-medium text-color mb-2 font-heading">Location:</h3>
                                @if (isset($hostelConfigs['physical_address']))
                                    <p class="text-body font-heading text-sm">{{ $hostelConfigs['physical_address'] }}</p>
                                @endif
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <h3 class="text-base font-medium text-color mb-2 font-heading">WhatsApp number:</h3>
                                @if (isset($hostelConfigs['social_whatsapp']))
                                    <p class="text-body font-heading text-sm">+977-{{ $hostelConfigs['social_whatsapp'] }}
                                    </p>
                                @endif
                            </div>

                            <!-- Social Media -->
                            <div>
                                <h3 class="text-base font-medium text-color mb-3 font-heading">Social Media:</h3>
                                <div class="flex space-x-1">
                                    @if (isset($hostelConfigs['social_facebook']))
                                        <a href="{{ $hostelConfigs['social_facebook'] }}"
                                            class="w-[30px] h-[30px] bg-[#076166] hover:bg-[#003135] rounded-full flex items-center justify-center hover:opacity-90 transition-opacity">
                                            <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12 2.04c-5.5 0-10 4.49-10 10.02c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89c1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02" />
                                            </svg>
                                        </a>
                                        <a href="{{ $hostelConfigs['social_instagram'] }}"
                                            class="w-[30px] h-[30px] bg-[#076166] hover:bg-[#003135] rounded-full flex items-center justify-center hover:opacity-90 transition-opacity">
                                            <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12.001 9a3 3 0 1 0 0 6a3 3 0 0 0 0-6m0-2a5 5 0 1 1 0 10a5 5 0 0 1 0-10m6.5-.25a1.25 1.25 0 0 1-2.5 0a1.25 1.25 0 0 1 2.5 0M12.001 4c-2.474 0-2.878.007-4.029.058c-.784.037-1.31.142-1.798.332a2.9 2.9 0 0 0-1.08.703a2.9 2.9 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.007 9.075 4 9.461 4 12c0 2.475.007 2.878.058 4.029c.037.783.142 1.31.331 1.797c.17.435.37.748.702 1.08c.337.336.65.537 1.08.703c.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.475 0 2.878-.007 4.029-.058c.782-.037 1.308-.142 1.797-.331a2.9 2.9 0 0 0 1.08-.703c.337-.336.538-.649.704-1.08c.19-.492.296-1.018.332-1.8c.052-1.103.058-1.49.058-4.028c0-2.474-.007-2.878-.058-4.029c-.037-.782-.143-1.31-.332-1.798a2.9 2.9 0 0 0-.703-1.08a2.9 2.9 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.926 4.006 14.54 4 12 4m0-2c2.717 0 3.056.01 4.123.06c1.064.05 1.79.217 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.047 1.066.06 1.405.06 4.122s-.01 3.056-.06 4.122s-.218 1.79-.465 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465c-1.067.047-1.406.06-4.123.06s-3.056-.01-4.123-.06c-1.064-.05-1.789-.218-2.427-.465a4.9 4.9 0 0 1-1.772-1.153a4.9 4.9 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.012 15.056 2 14.717 2 12s.01-3.056.06-4.122s.217-1.79.465-2.428a4.9 4.9 0 0 1 1.153-1.772A4.9 4.9 0 0 1 5.45 2.525c.637-.248 1.362-.415 2.427-.465C8.945 2.013 9.284 2 12.001 2" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Location Section end -->

    <!-- Reviews Section start -->
    <section class="mt-10 bg-white">
        <div class="container mx-auto px-4 md:px-8 lg:px-[120px] max-w-[1920px]">
            <!-- Section Header -->
            <div class="mb-10">
                <h2 class="text-2xl md:text-xl font-bold text-color mb-4 font-heading tracking-tight">All reviews</h2>
                <div class="w-full h-[0.5px] bg-[#E1DFDF]"></div>
            </div>

            <!-- Reviews Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Review Card 1 -->
                @foreach ($reviews as $review)
                    <div class="bg-white rounded-lg border border-[#E1DFDF] p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-[#F5F5F5]">
                                    <img src="{{ asset('storage/images/reviewImages/' . $review->person_image) }}"
                                        alt="{{ $review->person_name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-color font-heading">{{ $review->person_name }}
                                    </h3>
                                    <p class="text-xs sub-text font-regular font-heading">{{ $review->person_address }} •
                                        {{ \Carbon\Carbon::parse($review->review_date)->format('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <span class="sub-text font-medium font-heading text-sm">{{ $review->rating }}</span>
                                    <span class="sub-text font-medium font-heading text-sm">/5</span>
                                </div>
                                <svg class="w-5 h-5 text-[#8BC34A] ml-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-body font-regular tracking-tight font-heading text-sm leading-6 mb-3 text-justify">
                            {{ strip_tags($review->person_statement) }}
                        </p>
                        <button
                            class="flex items-center gap-1 px-3 py-1.5 sub-text hover-text-color border border-transparent hover:border-[#E1DFDF] rounded-md transition-all duration-200 hover:bg-white hover:shadow-custom-combo">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="text-xs font-heading font-regular tracking-tight">Helpful (5)</span>
                        </button>
                    </div>
                @endforeach
                <!-- Additional Review Cards... -->
            </div>

            <!-- Pagination -->
            {{-- <div class="flex justify-center items-center gap-1 mt-8">
                <!-- First Page -->
                <button class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Previous Page -->
                <button class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Page Numbers -->
                <button
                    class="w-8 h-8 flex items-center justify-center rounded bg-[#00A1A5] text-white font-medium text-sm">1</button>
                <button
                    class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100 font-medium text-sm">2</button>
                <button
                    class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100 font-medium text-sm">3</button>
                <span class="sub-text">...</span>
                <button
                    class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100 font-medium text-sm">10</button>

                <!-- Next Page -->
                <button class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Last Page -->
                <button class="w-8 h-8 flex items-center justify-center rounded sub-text hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </section>
    <!-- Reviews Section end -->

    <!-- Hidden Printable Receipt Template -->
    <div id="printableReceipt" style="display: none;">
        <div
            style="max-width: 800px; margin: 0 auto; padding: 30px 40px; font-family: Arial, sans-serif; background: white;">
            <!-- Header -->
            <div style="text-align: center; border-bottom: 3px solid #00A1A5; padding-bottom: 15px; margin-bottom: 20px;">
                <h1 style="color: #00A1A5; font-size: 28px; margin: 0 0 8px 0; font-weight: bold;">BOOKING CONFIRMATION
                </h1>
                <p style="color: #6A767C; font-size: 12px; margin: 0;">Thank you for choosing our hostel accommodation
                    service</p>
            </div>

            <!-- Booking ID -->
            <div style="background: #EEF6F2; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                <p style="margin: 0; color: #6A767C; font-size: 11px; font-weight: 600; text-transform: uppercase;">Booking
                    Reference</p>
                <p id="print_booking_id" style="margin: 4px 0 0 0; color: #00A1A5; font-size: 20px; font-weight: bold;">
                    #0000</p>
            </div>

            <!-- Two Column Layout -->
            <div style="display: table; width: 100%; margin-bottom: 20px;">
                <!-- Left Column -->
                <div style="display: table-cell; width: 50%; padding-right: 15px; vertical-align: top;">
                    <!-- Guest Information -->
                    <div style="margin-bottom: 20px;">
                        <h2
                            style="color: #2D3748; font-size: 14px; border-bottom: 2px solid #E1DFDF; padding-bottom: 6px; margin-bottom: 10px; font-weight: 600;">
                            Guest Information</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Full Name:</td>
                                <td id="print_full_name"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Email:</td>
                                <td id="print_email"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Phone:</td>
                                <td id="print_phone"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Stay Details -->
                    <div style="margin-bottom: 20px;">
                        <h2
                            style="color: #2D3748; font-size: 14px; border-bottom: 2px solid #E1DFDF; padding-bottom: 6px; margin-bottom: 10px; font-weight: 600;">
                            Stay Details</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Move-in Date:</td>
                                <td id="print_move_in_date"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Duration:</td>
                                <td id="print_duration"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Occupants:</td>
                                <td id="print_occupant_count"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: table-cell; width: 50%; padding-left: 15px; vertical-align: top;">
                    <!-- Accommodation Details -->
                    <div style="margin-bottom: 20px;">
                        <h2
                            style="color: #2D3748; font-size: 14px; border-bottom: 2px solid #E1DFDF; padding-bottom: 6px; margin-bottom: 10px; font-weight: 600;">
                            Accommodation Details</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Hostel:</td>
                                <td id="print_hostel_name"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Room:</td>
                                <td id="print_room_number"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Type:</td>
                                <td id="print_room_type"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Block:</td>
                                <td id="print_block_name"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Location:</td>
                                <td id="print_location"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600;">-</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Payment Summary -->
                    <div style="margin-bottom: 20px;">
                        <h2
                            style="color: #2D3748; font-size: 14px; border-bottom: 2px solid #E1DFDF; padding-bottom: 6px; margin-bottom: 10px; font-weight: 600;">
                            Payment Summary</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Monthly Rent:</td>
                                <td id="print_monthly_rent"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600; text-align: right;">
                                    NPR 0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Security Deposit:</td>
                                <td id="print_security_deposit"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600; text-align: right;">
                                    NPR 0.00</td>
                            </tr>
                            <tr style="border-top: 2px solid #E1DFDF;">
                                <td style="padding: 8px 0 4px 0; color: #2D3748; font-size: 14px; font-weight: bold;">Total
                                    Amount:</td>
                                <td id="print_total_amount"
                                    style="padding: 8px 0 4px 0; color: #00A1A5; font-size: 16px; font-weight: bold; text-align: right;">
                                    NPR 0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 4px 0; color: #6A767C; font-size: 12px;">Payment Method:</td>
                                <td id="print_payment_method"
                                    style="padding: 4px 0; color: #2D3748; font-size: 12px; font-weight: 600; text-align: right;">
                                    -</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 12px; margin-bottom: 20px;">
                <p style="margin: 0; color: #92400E; font-size: 11px; line-height: 1.5;">
                    <strong>Important:</strong> This is a booking confirmation. Shortly, you will be contacted by the Hostel
                    Department to complete the verification process. Please keep this receipt for your records.
                </p>
            </div>

            <!-- Footer -->
            <div style="text-align: center; padding-top: 15px; border-top: 2px solid #E1DFDF;">
                <p id="print_booked_at" style="margin: 0 0 8px 0; color: #6A767C; font-size: 11px;">Booked on: -</p>
                <p style="margin: 0; color: #6A767C; font-size: 10px;">This is a computer-generated document. No signature
                    is required.</p>
            </div>
        </div>
    </div>

    <script>
        // Show booking confirmation popup
        @if (session('booking_details'))
            document.addEventListener('DOMContentLoaded', function() {
                const bookingDetails = @json(session('booking_details'));

                // Populate printable receipt
                document.getElementById('print_booking_id').textContent = '#' + bookingDetails.booking_id;
                document.getElementById('print_full_name').textContent = bookingDetails.full_name;
                document.getElementById('print_email').textContent = bookingDetails.email;
                document.getElementById('print_phone').textContent = bookingDetails.phone;
                document.getElementById('print_hostel_name').textContent = bookingDetails.hostel_name;
                document.getElementById('print_room_number').textContent = bookingDetails.room_number;
                document.getElementById('print_room_type').textContent = bookingDetails.room_type;
                document.getElementById('print_block_name').textContent = bookingDetails.block_name;
                document.getElementById('print_location').textContent = bookingDetails.location;
                document.getElementById('print_move_in_date').textContent = bookingDetails.move_in_date;
                document.getElementById('print_duration').textContent = bookingDetails.duration + ' month(s)';
                document.getElementById('print_occupant_count').textContent = bookingDetails.occupant_count +
                    ' person(s)';
                document.getElementById('print_monthly_rent').textContent = 'NPR ' + bookingDetails.monthly_rent;
                document.getElementById('print_security_deposit').textContent = 'NPR ' + bookingDetails
                    .security_deposit;
                document.getElementById('print_total_amount').textContent = 'NPR ' + bookingDetails.total_amount;
                document.getElementById('print_payment_method').textContent = bookingDetails.payment_method;
                document.getElementById('print_booked_at').textContent = 'Booked on: ' + bookingDetails.booked_at;

                // Show SweetAlert popup
                Swal.fire({
                    title: '<strong style="color: #00A1A5;">Booking Confirmed!</strong>',
                    html: `
                        <div style="text-align: left; padding: 20px;">
                            <p style="font-size: 16px; color: #2D3748; margin-bottom: 20px;">
                                You have successfully booked a room at <strong>${bookingDetails.hostel_name}</strong>.
                            </p>

                            <div style="background: #EEF6F2; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <p style="margin: 0 0 8px 0; color: #6A767C; font-size: 12px;">BOOKING ID</p>
                                <p style="margin: 0; color: #00A1A5; font-size: 20px; font-weight: bold;">#${bookingDetails.booking_id}</p>
                            </div>

                            <div style="background: #F9FAFB; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <table style="width: 100%; font-size: 14px;">
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Room:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.room_type} - Room ${bookingDetails.room_number}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Move-in Date:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.move_in_date}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Duration:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.duration} month(s)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Total Amount:</td>
                                        <td style="padding: 5px 0; color: #00A1A5; font-weight: bold; font-size: 16px; text-align: right;">NPR ${bookingDetails.total_amount}</td>
                                    </tr>
                                </table>
                            </div>

                            <div style="background: #FEF3C7; padding: 12px; border-radius: 8px; border-left: 4px solid #F59E0B;">
                                <p style="margin: 0; color: #92400E; font-size: 13px; line-height: 1.5;">
                                    <strong>Note:</strong> Shortly, you will be contacted by the Hostel Department to complete the verification process.
                                </p>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    iconColor: '#00A1A5',
                    width: 600,
                    confirmButtonText: '<i class="fa fa-print"></i> Print Receipt',
                    confirmButtonColor: '#00A1A5',
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#6A767C',
                    customClass: {
                        popup: 'booking-popup',
                        confirmButton: 'print-button',
                        cancelButton: 'close-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Print the receipt
                        printReceipt();
                    }
                });
            });

            function printReceipt() {
                const bookingDetails = @json(session('booking_details'));
                const printContent = document.getElementById('printableReceipt').innerHTML;
                const originalContent = document.body.innerHTML;
                const originalTitle = document.title;

                // Set custom filename for print/save
                document.title =
                    `${bookingDetails.hostel_name} - Room ${bookingDetails.room_number} - Booking by ${bookingDetails.full_name}`;

                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;
                document.title = originalTitle;

                // Reload to restore functionality
                location.reload();
            }
        @endif
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printableReceipt,
            #printableReceipt * {
                visibility: visible;
            }

            #printableReceipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
            }
        }

        .booking-popup {
            font-family: 'Inter', sans-serif;
        }

        .print-button,
        .close-button {
            padding: 12px 30px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
        }

        .swal-wide {
            width: 600px !important;
            max-width: 90% !important;
        }
    </style>

@endsection
