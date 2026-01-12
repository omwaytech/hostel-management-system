@extends('frontend.layouts.mainPortal')

@section('body')
    <!-- Hosteldetial banner start -->
    <section class="bg-[#e0e2e5] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-xl font-bold text-color mb-2 sm:mb-0 font-heading">{{ $hostelDetail->name }}</h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">HostelDetials</span>
            </nav>
        </div>
    </section>
    <!-- Hosteldetial banner end -->
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
                            @forelse($hostelDetail->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/hostelImages/' . $image->image) }}"
                                        alt="{{ $hostelDetail->name }}" class="w-full h-[400px] object-cover">
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <img src="https://via.placeholder.com/800x400?text=No+Image+Available" alt="No Image"
                                        class="w-full h-[400px] object-cover">
                                </div>
                            @endforelse
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
                            class="swiper-button-next !w-9 !h-9 md:!w-9 md:!h-9 bg-white rounded-full shadow-custom-combo border border-[#E1DFDF] !right-4 md:!right-6 after:!content-none flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-color" width="16" height="16"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="0.8" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                            </svg>
                        </div>
                        @endforelse
                    </div>
                    @if (count($hostelDetail->images) > 1)
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
                        class="swiper-button-next !w-9 !h-9 md:!w-9 md:!h-9 bg-white rounded-full shadow-custom-combo border border-[#E1DFDF] !right-4 md:!right-6 after:!content-none flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-color" width="16" height="16"
                            viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-miterlimit="10" stroke-width="0.8" d="m14 16l4-4m0 0l-4-4m4 4H6" />
                        </svg>
                    </div>
                    @endif
                </div>

                @if (count($hostelDetail->images) > 1)
                <!-- Thumbnail Slider -->
                <div class="swiper thumbSwiper mt-4">
                    <div class="swiper-wrapper">
                        @foreach ($hostelDetail->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/images/hostelImages/' . $image->image) }}"
                                alt="{{ $hostelDetail->name }}"
                                class="w-full h-16 sm:h-20 object-cover cursor-pointer opacity-70 hover:opacity-100 transition-opacity duration-200">
                    </div>

                    <!-- Thumbnail Slider -->
                    <div class="swiper thumbSwiper mt-4">
                        <div class="swiper-wrapper">
                            @foreach ($hostelDetail->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/images/hostelImages/' . $image->image) }}"
                                        alt="{{ $hostelDetail->name }}"
                                        class="w-full h-16 sm:h-20 object-cover cursor-pointer opacity-70 hover:opacity-100 transition-opacity duration-200">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

                <!-- Room Features -->
                <div class="mt-10 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
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
                <div class="rounded-lg border border-[#E1DFDF] p-6 mt-6">
                    <h2 class="text-lg font-medium text-color mb-3 font-heading">About Hostel</h2>
                    <p class="leading-[25px] text-sm font-heading font-regular text-body text-justify">
                        {!! $hostelDetail->description ?? 'No description available for this hostel.' !!}
                    </p>
                </div>
                <div class="rounded-lg border border-[#E1DFDF] p-6 mb-6 mt-6">
                    <h2 class="text-base mt-3 font-medium text-color mb-3 font-heading">What Included</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        @forelse($hostelFeatures as $feature)
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-[#087878]" width="16" height="16"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4 12a8 8 0 1 1 16 0a8 8 0 0 1-16 0m8-10C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2m5.457 7.457l-1.414-1.414L11 13.086l-2.793-2.793l-1.414 1.414L11 15.914z" />
                                </svg>
                                {{-- <img src="{{ asset('storage/images/icons/' . $feature->feature_icon) }}"
                                    alt="{{ $feature->feature_name }}" class="w-5 h-5 text-[#087878]"> --}}
                                <span
                                    class="text-body text-sm font-heading font-regular">{{ $feature->feature_name }}</span>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <p class="text-body text-sm font-heading font-regular text-gray-500">No features available
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Amenities -->
                <div class="rounded-lg border border-color p-6">
                    <h2 class="text-lg font-medium text-color mb-6 font-heading">Amenities</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        @forelse($hostelDetail->amenities as $amenity)
                            <div class="flex items-center gap-3 bg-[#f1f4f4] rounded-lg p-4">
                                @if ($amenity->amenity_icon)
                                    <img src="{{ asset('storage/images/icons/' . $amenity->amenity_icon) }}"
                                        alt="{{ $amenity->amenity_name }}" class="w-5 h-5 text-[#087878]">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#087878]"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M4 12a8 8 0 1 1 16 0a8 8 0 0 1-16 0m8-10C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2m5.457 7.457l-1.414-1.414L11 13.086l-2.793-2.793l-1.414 1.414L11 15.914z" />
                                    </svg>
                                @endif
                                <span
                                    class="text-sm text-body font-heading font-regular">{{ $amenity->amenity_name }}</span>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <p class="text-body text-sm font-heading font-regular text-gray-500">No amenities available
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="rounded-lg border border-color p-6 mt-6">
                    <h2 class="text-lg font-medium text-color mb-6 font-heading">Location</h2>
                    @if (isset($hostelConfigs['google_map_embed']) && $hostelConfigs['google_map_embed'])
                        <iframe src="{{ $hostelConfigs['google_map_embed'] }}" width="100%" height="450"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="bg-gray-100 h-[450px] flex items-center justify-center rounded-lg">
                            <p class="text-gray-500 font-heading">Map location not available</p>
                        </div>
                    @endif
                </div>
                <!-- Feedback Form Start -->
                <div class="rounded-lg border border-color p-6 mt-6 bg-white">
                    <h2 class="text-lg font-bold mb-1 font-heading">Give Feedback</h2>
                    <p class="text-sm text-gray-500 mb-4">How to satisfy you with your experience with us</p>

                    <form id="feedbackForm">
                        @csrf
                        <input type="hidden" name="hostel_id" value="{{ $hostelDetail->id }}">

                        <!-- Rate (interactive) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rate Your Experience</label>
                            <div class="flex items-center gap-1" role="radiogroup" aria-label="Rating">
                                <input type="hidden" id="feedback_rating" name="rating" value="0">
                                <button type="button"
                                    class="feedback-star text-gray-300 hover:text-yellow-400 transition-colors transform hover:scale-105"
                                    data-value="1" aria-label="1 star" role="radio" aria-checked="false"
                                    tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="feedback-star text-gray-300 hover:text-yellow-400 transition-colors transform hover:scale-105"
                                    data-value="2" aria-label="2 stars" role="radio" aria-checked="false"
                                    tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="feedback-star text-gray-300 hover:text-yellow-400 transition-colors transform hover:scale-105"
                                    data-value="3" aria-label="3 stars" role="radio" aria-checked="false"
                                    tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="feedback-star text-gray-300 hover:text-yellow-400 transition-colors transform hover:scale-105"
                                    data-value="4" aria-label="4 stars" role="radio" aria-checked="false"
                                    tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="feedback-star text-gray-300 hover:text-yellow-400 transition-colors transform hover:scale-105"
                                    data-value="5" aria-label="5 stars" role="radio" aria-checked="false"
                                    tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    <!-- Thoughts -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 mb-2">Do you have any thoughts you'd like to
                            share?</label>
                        <textarea id="feedback_review_text" name="review_text"
                            class="w-full min-h-[120px] text-sm font-light font-heading text-color px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none"
                            placeholder="Enter a description..."></textarea>
                    </div>
                    <!-- Buttons -->
                    <div class="mt-6 mb-5 flex flex-wrap gap-3">
                        <button type="submit" id="submitFeedbackBtn"
                            class="flex items-center justify-center font-heading text-sm rounded-[50px]  px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0]  hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0]">
                            Submit Feedback
                        </button>
                    </div>
                </form>
                <!-- User Review start -->
                <section id="reviews-section" class="py-12 md:py-16">
                        <!-- Thoughts -->
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-2">Do you have any thoughts you'd like to
                                share?</label>
                            <textarea id="feedback_review_text" name="review_text"
                                class="w-full min-h-[120px] text-sm font-light font-heading text-color px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none"
                                placeholder="Enter a description..."></textarea>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-6 mb-5 flex flex-wrap gap-3">
                            <button type="submit" id="submitFeedbackBtn"
                                class=" button-color text-color hover:bg-[#023be4] hover:text-[white] border border-color px-6 py-2 rounded-full font-bold font-heading transition text-sm">
                                Submit Feedback
                            </button>
                        </div>
                    </form>
                    <!-- User Review start -->
                    <section id="reviews-section" class="py-12 md:py-16">

                        <!-- Section Header -->
                        <h3 class="text-xl font-bold mb-6 font-heading">Customer Reviews</h3>

                        <!-- Reviews Grid -->
                        <div id="reviewsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        </div>
                        <div id="reviewsPagination" class="flex justify-center items-center gap-2 mt-8">

                        </div>

                    </section>
                    <!-- user review end -->
                </div>
                <script>
                    (function() {
                        const stars = document.querySelectorAll('.feedback-star');
                        const input = document.getElementById('feedback_rating');
                        const feedbackForm = document.getElementById('feedbackForm');
                        const reviewsContainer = document.getElementById('reviewsContainer');
                        const hostelId = {{ $hostelDetail->id }};
                        let selected = Number(input?.value) || 0;

                        function updateStars(value) {
                            stars.forEach(star => {
                                const v = Number(star.getAttribute('data-value'));
                                if (v <= value) {
                                    star.classList.remove('text-gray-300');
                                    star.classList.add('text-yellow-400');
                                    star.setAttribute('aria-checked', 'true');
                                } else {
                                    star.classList.remove('text-yellow-400');
                                    star.classList.add('text-gray-300');
                                    star.setAttribute('aria-checked', 'false');
                                }
                            });
                        }

                        function bind() {
                            stars.forEach(star => {
                                const val = Number(star.getAttribute('data-value'));
                                star.addEventListener('click', () => {
                                    selected = val;
                                    if (input) input.value = String(selected);
                                    updateStars(selected);
                                });
                                star.addEventListener('keydown', (e) => {
                                    if (e.key === 'Enter' || e.key === ' ') {
                                        e.preventDefault();
                                        selected = val;
                                        if (input) input.value = String(selected);
                                        updateStars(selected);
                                    }
                                });
                                star.addEventListener('mouseover', () => {
                                    updateStars(val);
                                });
                                star.addEventListener('mouseout', () => {
                                    updateStars(selected);
                                });
                            });
                            // initial render
                            updateStars(selected);
                        }

                        if (stars.length) bind();

                        // Load reviews with pagination
                        function loadReviews(page = 1) {
                            fetch(`/hostel-reviews/${hostelId}?page=${page}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        displayReviews(data.reviews);
                                        displayPagination(data.pagination);
                                    }
                                })
                                .catch(error => console.error('Error loading reviews:', error));
                        }

                        // Display pagination
                        function displayPagination(pagination) {
                            const paginationContainer = document.getElementById('reviewsPagination');

                            if (!pagination || pagination.last_page <= 1) {
                                paginationContainer.innerHTML = '';
                                return;
                            }

                            let html = '';

                            // Previous button
                            if (pagination.current_page === 1) {
                                html += `<span class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-300 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>`;
                            } else {
                                html += `<a href="#" data-page="${pagination.current_page - 1}" class="review-page-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
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
                                        `<a href="#" data-page="${i}" class="review-page-link w-8 h-8 flex items-center justify-center rounded-full sub-text hover:bg-[#e3e8f3] font-medium text-sm">${i}</a>`;
                                }
                            }

                            // Next button
                            if (pagination.has_more_pages) {
                                html += `<a href="#" data-page="${pagination.current_page + 1}" class="review-page-link w-8 h-8 flex items-center justify-center rounded-full border border-color shadow-custom-combo sub-text hover:bg-[#7790c2] text-black hover:text-white">
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

                            paginationContainer.innerHTML = html;

                            // Add event listeners to pagination links
                            document.querySelectorAll('.review-page-link').forEach(link => {
                                link.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const page = this.getAttribute('data-page');
                                    loadReviews(page);

                                    // Scroll to reviews section
                                    const reviewsSection = document.getElementById('reviews-section');
                                    if (reviewsSection) {
                                        reviewsSection.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                    }
                                });
                            });
                        }

                        // Display reviews
                        function displayReviews(reviews) {
                            if (reviews.length === 0) {
                                reviewsContainer.innerHTML =
                                    '<p class="text-gray-500 col-span-2">No reviews yet. Be the first to review!</p>';
                                return;
                            }

                            reviewsContainer.innerHTML = reviews.map(review => `
                                <div class="bg-white rounded-lg border border-[#E1DFDF] p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            ${review.user_photo
                                                ? `<div class="w-9 h-9 rounded-full overflow-hidden">
                                                                                                                                                                                                    <img src="${review.user_photo}" alt="${review.user_name}" class="w-full h-full object-cover">
                                                                                                                                                                                                   </div>`
                                                : `<div class="w-9 h-9 rounded-full overflow-hidden bg-[#023BE4] flex items-center justify-center text-white font-bold">
                                                                                                                                                                                                    ${review.user_name.charAt(0).toUpperCase()}
                                                                                                                                                                                                   </div>`
                                            }
                                            <div>
                                                <h3 class="text-sm font-medium text-color font-heading">${review.user_name}</h3>
                                                <p class="text-xs sub-text font-regular mt-1 font-heading">${review.created_at}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <span class="sub-text font-medium font-heading text-sm">${review.rating}</span>
                                                <span class="sub-text font-medium font-heading text-sm">/5</span>
                                            </div>
                                            <svg class="w-5 h-5 text-[#8BC34A] ml-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-body font-regular tracking-tight font-heading text-sm leading-6 mb-3 text-justify">
                                        ${review.review_text || 'No comment provided.'}
                                    </p>
                                </div>
                            `).join('');
                        }

                        // Handle form submission
                        if (feedbackForm) {
                            feedbackForm.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const rating = document.getElementById('feedback_rating').value;

                                if (rating === '0' || !rating) {
                                    toastr.warning('Please select a rating before submitting.');
                                    return;
                                }

                                const formData = new FormData(feedbackForm);

                                fetch('{{ route('hostelReviews.store') }}', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.requiresLogin) {
                                            // User not logged in - trigger login modal from navbar
                                            const loginBtn = document.getElementById('loginBtn');
                                            if (loginBtn) {
                                                // Save form data to sessionStorage
                                                sessionStorage.setItem('pendingReview', JSON.stringify({
                                                    hostel_id: hostelId,
                                                    rating: rating,
                                                    review_text: document.getElementById(
                                                        'feedback_review_text').value
                                                }));
                                                loginBtn.click();
                                            } else {
                                                toastr.info('Please login to submit a review.');
                                                window.location.href =
                                                    '{{ route('hostel.signin', $hostelDetail->slug ?? 'default') }}';
                                            }
                                        } else if (data.success) {
                                            toastr.success(data.message);
                                            // Reset form
                                            feedbackForm.reset();
                                            document.getElementById('feedback_rating').value = '0';
                                            selected = 0;
                                            updateStars(0);
                                            // Reload reviews
                                            loadReviews();
                                        } else {
                                            toastr.error(data.message || 'An error occurred. Please try again.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        toastr.error('An error occurred. Please try again.');
                                    });
                            });
                        }

                        // Load reviews on page load
                        loadReviews();

                        // Check for pending review after login
                        const pendingReview = sessionStorage.getItem('pendingReview');
                        if (pendingReview && {{ auth()->check() ? 'true' : 'false' }}) {
                            const reviewData = JSON.parse(pendingReview);
                            if (reviewData.hostel_id == hostelId) {
                                // Auto-submit the pending review
                                document.getElementById('feedback_rating').value = reviewData.rating;
                                document.getElementById('feedback_review_text').value = reviewData.review_text;
                                selected = reviewData.rating;
                                updateStars(selected);

                                // Clear pending review
                                sessionStorage.removeItem('pendingReview');

                                // Submit after a short delay to ensure page is fully loaded
                                setTimeout(() => {
                                    swal({
                                        title: 'Submit Review',
                                        text: 'Would you like to submit your review now?',
                                        type: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#10B981',
                                        cancelButtonColor: '#EF4444',
                                        confirmButtonText: 'Yes, Submit',
                                        cancelButtonText: 'No, Cancel'
                                    }).then((result) => {
                                        if (result) {
                                            feedbackForm.dispatchEvent(new Event('submit'));
                                        }
                                    });
                                }, 500);
                            }
                        }
                    })();
                </script>
                <!-- Feedback Form End -->

            </div>

            <!-- Right Section with Sticky Cards -->
            <div class="lg:w-1/3 space-y-6">
                <!-- Price Card - Sticky -->
                <div class="sticky top-[180px]">
                    <div class="max-w-md w-full space-y-6">
                        <!-- Hostel Fees Section -->
                        <div class="bg-white rounded-lg p-5 border border-color">
                            <h2 class="text-base font-bold text-color font-heading mb-3">Hostel Fees</h2>
                            <hr class="mb-6 mt-4">
                            <div class="space-y-4">
                                <!-- Admission Fee -->
                                <div class="flex items-center justify-between font-heading bg-[#e9f1fc]/50 p-4 rounded-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">₹</span>
                                        <span class="font-Regular text-color text-sm">Admission Fee</span>
                                    </div>
                                    <span class="font-medium text-color">20,000</span>
                                </div>

                                <!-- Deposit Fee -->
                                <div class="flex items-center justify-between font-heading bg-[#e9f1fc]/30 p-4 rounded-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">₹</span>
                                        <span class="font-Regular text-color text-sm">Deposite Fee</span>
                                    </div>
                                    <span class="font-medium text-color text-base">15,000</span>
                                </div>
                            </div>
                        </div>
                        <!-- Contact Us Section -->
                        <div class="bg-white rounded-lg p-5 border border-color">
                            <h2 class="font-bold text-base text-color mb-3 font-heading">Contact Us</h2>
                            <hr class="mb-6 mt-4">

                            <!-- Phone -->
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sub-text" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.5 22a1.5 1.5 0 0 0 1.5-1.5V17a1.5 1.5 0 0 0-1.5-1.5c-1.17 0-2.32-.18-3.42-.55a1.51 1.51 0 0 0-1.52.37l-1.44 1.44a14.77 14.77 0 0 1-5.89-5.89l1.43-1.43c.41-.39.56-.97.38-1.53c-.36-1.09-.54-2.24-.54-3.41A1.5 1.5 0 0 0 7 3H3.5A1.5 1.5 0 0 0 2 4.5C2 14.15 9.85 22 19.5 22M3.5 4H7a.5.5 0 0 1 .5.5c0 1.28.2 2.53.59 3.72c.05.14.04.34-.12.5L6 10.68c1.65 3.23 4.07 5.65 7.31 7.32l1.95-1.97c.14-.14.33-.18.51-.13c1.2.4 2.45.6 3.73.6a.5.5 0 0 1 .5.5v3.5a.5.5 0 0 1-.5.5C10.4 21 3 13.6 3 4.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                                <span
                                    class="text-color font-light text-base font-heading">{{ $hostelDetail->contact ?? 'N/A' }}</span>
                            </div>

                            <!-- Email -->
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sub-text" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.435 4.065H4.565a2.5 2.5 0 0 0-2.5 2.5v10.87a2.5 2.5 0 0 0 2.5 2.5h14.87a2.5 2.5 0 0 0 2.5-2.5V6.565a2.5 2.5 0 0 0-2.5-2.5m-14.87 1h14.87a1.49 1.49 0 0 1 1.49 1.39c-2.47 1.32-4.95 2.63-7.43 3.95a6 6 0 0 1-1.06.53a2.08 2.08 0 0 1-1.67-.39c-1.42-.75-2.84-1.51-4.25-2.26c-1.14-.6-2.3-1.21-3.44-1.82a1.49 1.49 0 0 1 1.49-1.4m16.37 12.37a1.5 1.5 0 0 1-1.5 1.5H4.565a1.5 1.5 0 0 1-1.5-1.5V7.6c2.36 1.24 4.71 2.5 7.07 3.75a5.6 5.6 0 0 0 1.35.6a2.87 2.87 0 0 0 2-.41c1.45-.76 2.89-1.53 4.34-2.29c1.04-.56 2.07-1.1 3.11-1.65Z" />
                                </svg>
                                <a href="mailto:{{ $hostelDetail->email }}"
                                    class="text-color font-light text-base font-heading hover:text-[#023BE4]">
                                    {{ $hostelDetail->email ?? 'N/A' }}
                                </a>
                            </div>

                            <!-- Socials -->
                            <div class="flex items-center gap-3">
                                <span class="text-gray-700 font-medium">Socials:</span>
                                <div class="flex gap-2">
                                    @if (isset($hostelConfigs['social_facebook']) && $hostelConfigs['social_facebook'])
                                        <a href="{{ $hostelConfigs['social_facebook'] }}"
                                            class="bg-black hover:bg-[#163a8d] text-black hover:text-white w-7 h-7 flex items-center justify-center rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="20"
                                                height="20" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if (isset($hostelConfigs['social_whatsapp']) && $hostelConfigs['social_whatsapp'])
                                        <a href="{{ $hostelConfigs['social_whatsapp'] }}"
                                            class="bg-black hover:bg-[#163a8d] text-black hover:text-white w-7 h-7 flex items-center justify-center rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="20"
                                                height="20" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="m7.254 18.494l.724.423A7.95 7.95 0 0 0 12.001 20a8 8 0 1 0-8-8a7.95 7.95 0 0 0 1.084 4.024l.422.724l-.653 2.401zM2.005 22l1.352-4.968A9.95 9.95 0 0 1 2.001 12c0-5.523 4.477-10 10-10s10 4.477 10 10s-4.477 10-10 10a9.95 9.95 0 0 1-5.03-1.355zM8.392 7.308q.202-.014.403-.004q.081.006.162.016c.159.018.334.115.393.249q.447 1.015.868 2.04c.062.152.025.347-.093.537c-.06.097-.154.233-.263.372c-.113.145-.356.411-.356.411s-.099.118-.061.265c.014.056.06.137.102.205l.059.095c.256.427.6.86 1.02 1.268c.12.116.237.235.363.346c.468.413.998.75 1.57 1l.005.002c.085.037.128.057.252.11q.093.039.191.066q.036.01.073.011a.35.35 0 0 0 .295-.142c.723-.876.79-.933.795-.933v.002a.48.48 0 0 1 .378-.127q.092.004.177.04c.531.243 1.4.622 1.4.622l.582.261c.098.047.187.158.19.265c.004.067.01.175-.013.373c-.032.259-.11.57-.188.733a1.2 1.2 0 0 1-.21.302a2.4 2.4 0 0 1-.33.288q-.124.092-.125.09a5 5 0 0 1-.383.22a2 2 0 0 1-.833.23c-.185.01-.37.024-.556.014c-.008 0-.568-.087-.568-.087a9.45 9.45 0 0 1-3.84-2.046c-.226-.199-.436-.413-.65-.626c-.888-.885-1.561-1.84-1.97-2.742a3.5 3.5 0 0 1-.33-1.413a2.73 2.73 0 0 1 .565-1.68c.073-.094.142-.192.261-.305c.126-.12.207-.184.294-.228a1 1 0 0 1 .371-.1" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if (isset($hostelConfigs['social_instagram']) && $hostelConfigs['social_instagram'])
                                        <a href="{{ $hostelConfigs['social_instagram'] }}"
                                            class="bg-black hover:bg-[#163a8d] text-black hover:text-white w-7 h-7 flex items-center justify-center rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="20"
                                                height="20" viewBox="0 0 1024 1024">
                                                <path fill="currentColor"
                                                    d="M512 306.9c-113.5 0-205.1 91.6-205.1 205.1S398.5 717.1 512 717.1S717.1 625.5 717.1 512S625.5 306.9 512 306.9m0 338.4c-73.4 0-133.3-59.9-133.3-133.3S438.6 378.7 512 378.7S645.3 438.6 645.3 512S585.4 645.3 512 645.3m213.5-394.6c-26.5 0-47.9 21.4-47.9 47.9s21.4 47.9 47.9 47.9s47.9-21.3 47.9-47.9a47.84 47.84 0 0 0-47.9-47.9M911.8 512c0-55.2.5-109.9-2.6-165c-3.1-64-17.7-120.8-64.5-167.6c-46.9-46.9-103.6-61.4-167.6-64.5c-55.2-3.1-109.9-2.6-165-2.6c-55.2 0-109.9-.5-165 2.6c-64 3.1-120.8 17.7-167.6 64.5C132.6 226.3 118.1 283 115 347c-3.1 55.2-2.6 109.9-2.6 165s-.5 109.9 2.6 165c3.1 64 17.7 120.8 64.5 167.6c46.9 46.9 103.6 61.4 167.6 64.5c55.2 3.1 109.9 2.6 165 2.6c55.2 0 109.9.5 165-2.6c64-3.1 120.8-17.7 167.6-64.5c46.9-46.9 61.4-103.6 64.5-167.6c3.2-55.1 2.6-109.8 2.6-165m-88 235.8c-7.3 18.2-16.1 31.8-30.2 45.8c-14.1 14.1-27.6 22.9-45.8 30.2C695.2 844.7 570.3 840 512 840s-183.3 4.7-235.9-16.1c-18.2-7.3-31.8-16.1-45.8-30.2c-14.1-14.1-22.9-27.6-30.2-45.8C179.3 695.2 184 570.3 184 512s-4.7-183.3 16.1-235.9c7.3-18.2 16.1-31.8 30.2-45.8s27.6-22.9 45.8-30.2C328.7 179.3 453.7 184 512 184s183.3-4.7 235.9 16.1c18.2 7.3 31.8 16.1 45.8 30.2c14.1 14.1 22.9 27.6 30.2 45.8C844.7 328.7 840 453.7 840 512s4.7 183.2-16.2 235.8" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Apply Button -->
                        {{-- <button onclick="document.getElementById('notListedModal').classList.remove('hidden')"
                            class="w-full font-semibold py-3 text-base button-color text-color border border-[#E1E7EF] px-6 items-center justify-center gap-2 rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors">
                            Apply For Hostel
                        </button> --}}
                    <div class="flex justify-center">
                        <a href="{{ route('hostel.index', $hostelDetail->slug) }}">
                            <button type="submit" id="submitFeedbackBtn"
                                class=" flex items-center justify-center font-heading w-60 text-sm rounded-[50px]  px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0]  hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0]">
                        <a href="{{ route('hostel.index', $hostelDetail->slug) }}">
                            <button
                                class="mt-5 w-full font-semibold py-3 text-base button-color text-color border border-[#E1E7EF] px-6 items-center justify-center gap-2 rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors">
                                Visit Hostel Page
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Not Listed Modal -->
    <div id="notListedModal" class="fixed inset-0 bg-black bg-opacity-50 z-9999 hidden">
        <div class="min-h-screen px-4 text-center pt-24 sm:pt-0 md:px-0 lg:px-0">
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-medium leading-6 text-color font-heading">Hostel Status</h3>
                        <button onclick="document.getElementById('notListedModal').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700 font-heading">
                                        This hostel is currently not listed in our system.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Hostels -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h1 class="text-base md:text-lg font-heading font-bold text-color">Recommendation Hostels</h1>
                            <div class="flex gap-2">
                                <button id="prevBtn"
                                    class="p-1 rounded-full bg-white border border-color box-shadow hover:bg-[#e3e8f3]/40 transition disabled:opacity-50 disabled:cursor-not-allowed pointer-events-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                                            d="m10 16l-4-4m0 0l4-4m-4 4h12" />
                                    </svg>
                                </button>
                                <button id="nextBtn"
                                    class="p-1 rounded-full bg-white border border-color box-shadow hover:bg-[#e3e8f3]/40 transition disabled:opacity-50 disabled:cursor-not-allowed pointer-events-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                                            d="m14 16l4-4m0 0l-4-4m4 4H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="grid gap-4 max-w-4xl mx-auto">
                            <!-- Recommendation 1 -->
                            <div class="relative overflow-hidden z-0">
                                <div id="sliderContainer" class="slider-container flex gap-5 overflow-x-hidden">
                                    <!-- Cards will be generated by JavaScript -->
                                </div>
                            </div>
                        </div>

                    </div>
                    <script>
                        (function() {
                            const hostelsData = [{
                                    name: "The Green Nest Hostel",
                                    type: "Boys Hostel",
                                    rating: 4.8,
                                    reviews: 124,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1556020685-ae41abfc9365?w=500&h=400&fit=crop"
                                    ]
                                },
                                {
                                    name: "The Green Nest Hostel",
                                    type: "Girls Hostel",
                                    rating: 4.8,
                                    reviews: 124,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=400&fit=crop"
                                    ]
                                },
                                {
                                    name: "The Green Nest Hostel",
                                    type: "Girls Hostel",
                                    rating: 4.8,
                                    reviews: 124,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=500&h=400&fit=crop"
                                    ]
                                },
                                {
                                    name: "The Green Nest Hostel",
                                    type: "Boys Hostel",
                                    rating: 4.8,
                                    reviews: 124,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1556020685-ae41abfc9365?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop"
                                    ]
                                },
                                {
                                    name: "The Green Nest Hostel",
                                    type: "Boys Hostel",
                                    rating: 4.8,
                                    reviews: 124,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1556020685-ae41abfc9365?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop"
                                    ]
                                },
                                {
                                    name: "Sunset View Hostel",
                                    type: "Girls Hostel",
                                    rating: 4.9,
                                    reviews: 98,
                                    starting: "Starting from ₹15,000/month",
                                    images: [
                                        "https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=500&h=400&fit=crop",
                                        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=400&fit=crop"
                                    ]
                                }
                            ];

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

                                    this.startAutoSlide();
                                    this.cardElement.addEventListener('mouseenter', () => this.stopAutoSlide());
                                    this.cardElement.addEventListener('mouseleave', () => this.startAutoSlide());
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
                                    this.stopAutoSlide();
                                    this.startAutoSlide();
                                }

                                nextSlide() {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                    this.updateImage();
                                }

                                startAutoSlide() {
                                    this.stopAutoSlide();
                                    this.autoSlideInterval = setInterval(() => this.nextSlide(), 3000);
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
            <div class="flex-shrink-0 w-full sm:w-[calc(50%-12px)] bg-white rounded-[20px] border border-color box-shadow overflow-hidden hostel-card" data-card="${index}">
                <div class="relative group">
                 <!-- black overlay -->
                 <div class="absolute inset-0 bg-black/35 z-10"></div>
                    <span class="absolute top-4 right-4 bg-white text-color text-xs px-4 py-1.5 rounded-sm font-medium z-10 shadow-md">
                        ${hostel.type}
                    </span>
                    <div class="relative h-36 overflow-hidden">
                        <img src="${hostel.images[0]}" alt="${hostel.name}"
                             class="card-image w-full h-full object-cover transition-opacity duration-200 opacity-100">
                    </div>
                    <div class="absolute bottom-4 left-2/3 transform -translate-x-1/2 flex gap-2 z-10">
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
                        <span class="text-base font-bold text-color font-heading">${hostel.rating}</span>
                        <span class="text-sm sub-text font-heading">(${hostel.reviews})</span>
                        <span class="text-sm font-heading sub-text font-regular">Excellent Rating</span>
                    </div>
                     <div class="flex items-center gap-1 mb-2">
                       <span class="text-sm font-heading sub-text font-regular">${hostel.starting}</span>
                    </div>
                    <div class="relative z-20">
                    <a href="#">
                     <button
                            class="text-[#0e70d5] text-sm font-heading hover:text-[#0230be] hover:underline cursor-pointer mt-4 flex items-center pointer-events-auto">
                            View Details
                        </button>
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
                                // Clear existing content and sliders
                                sliderContainer.innerHTML = '';
                                sliders.forEach(slider => slider.destroy());
                                sliders = [];

                                // Create and append cards one by one
                                hostelsData.forEach((hostel, index) => {
                                    const cardHtml = createCard(hostel, index);
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = cardHtml;
                                    const cardElement = tempDiv.firstElementChild;
                                    sliderContainer.appendChild(cardElement);
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
                                if (width >= 640) return 2; // Show 2 cards on medium screens and up
                                return 1; // Show 1 card on mobile
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
                                stopAutoSlide();
                                autoSlideInterval = setInterval(() => {
                                    const cardsPerView = getCardsPerView();
                                    if (currentSlide >= hostelsData.length - cardsPerView) {
                                        goToSlide(0);
                                    } else {
                                        nextSlide();
                                    }
                                }, 4000);
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
                                    stopAutoSlide();
                                    startAutoSlide();
                                });

                                nextBtn.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    nextSlide();
                                    stopAutoSlide();
                                    startAutoSlide();
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
                                sliderContainer.addEventListener('mouseleave', startAutoSlide);

                                window.addEventListener('resize', () => {
                                    updateButtonStates();
                                    goToSlide(currentSlide);
                                });

                                setTimeout(() => {
                                    updateButtonStates();
                                    startAutoSlide();
                                }, 100);
                            }

                            // Initialize immediately
                            init();
                        })();
                    </script>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="document.getElementById('notListedModal').classList.add('hidden')"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#023BE4] text-base font-medium text-white hover:bg-[#0230be] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
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
