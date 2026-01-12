@extends('frontend.layouts.hostelPortal')

@section('body')
<!-- About Banner start -->
<section class="bg-[#E5E4E2] w-full min-h-[80px] py-4 flex items-center sticky top-[88px] z-50">
    <div
        class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full gap-2">
        <!-- Left Section -->
        <h1 class="text-xl sm:text-2xl font-bold text-color font-heading whitespace-nowrap">About us</h1>

        <!-- Right Section (Breadcrumb) -->
        <nav class="text-sm sm:text-base font-medium text-color font-heading flex items-center space-x-0.5 whitespace-nowrap">
            <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                    d="m19 12l12 12l-12 12" />
            </svg>
            <span class="text-[#535b6a]">About us</span>
        </nav>
    </div>
</section>
<!-- About Banner end -->

<!-- About Content start -->
<section class="mt-10">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px]">
        <div class="bg-white p-12 rounded-[8px] shadow-custom-combo">
            <!-- Section Title -->
            <h2 class="text-lg font-medium text-subcolor font-heading tracking-tight">{{ $about->about_title ?? 'N/A' }}
            </h2>

            <!-- Rating Tag -->
            <div
                class=" inline-flex items-center text-sm font-semibold  mb-6 bg-[#027E83] text-white py-2 md:py-2.5 px-4 md:px-6 rounded-full gap-1.5 md:gap-1 shadow-sm mt-6 md:mt-6">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-white fill-current" viewBox="0 0 24 24">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <span class="font-bold text-base md:text-base font-heading tracking-tight">Rated 8.9 Excellent</span>
            </div>
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Left Column -->
                <div class=" text-[#443838] text-sm sm:text-base font-heading font-regular text-justify
                tracking-tight">
                    <p class="leading-6">
                        {!! $about->about_description ?? 'N/A' !!}
                    </p>
                    {{-- <p class="mt-4 leading-6">
                            Whether you're here for the hiking trails, the cultural sites, or just to experience the local
                            vibe, our friendly multilingual
                            staff is here to help you make the most of your stay. Join us for regular social events, explore
                            with our guided tours, or
                            simply relax on our rooftop terrace with panoramic views of the surrounding peaks.
                        </p> --}}
                </div>

                <!-- Right Column -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4 text-sm sm:text-base">
                    <!-- Property Amenities -->
                    <div>
                        <h3 class="font-medium text-color text-xl mb-3 tracking-tight font-heading">
                            Property Amenities
                        </h3>
                        <ul class="space-y-4 text-[#333333] font-heading font-regular">
                            @foreach ($hostel->amenities as $amenity)
                            <li class="flex items-center space-x-2">
                                <img src="{{ asset('storage/images/icons/' . $amenity->amenity_icon) }}"
                                    alt="Shared dorms" class="w-5 h-5">
                                <span>{{ $amenity->amenity_name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Room Features -->
                    <div>
                        <h3 class="font-medium text-color text-xl mb-3 tracking-tight font-heading">Room Features
                        </h3>
                        <ul class="space-y-4 text-[#333333] font-heading font-regular">
                            @foreach ($hostelFeatures as $feature)
                            <li class="flex items-center space-x-2">
                                <img src="{{ asset('storage/images/icons/' . $feature->feature_icon) }}"
                                    alt="{{ $feature->feature_name }}" class="w-5 h-5">
                                <span>{{ $feature->feature_name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Content end -->

<!-- Mission vision section start -->
<section class="mt-10">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px]">
        <div class="bg-white p-9 rounded-[8px] shadow-custom-combo -z-10">
            <div class="flex flex-col md:flex-row relative items-center">
                <!-- Vertical dividers with fixed height -->
                <div class="hidden md:block absolute left-1/3 h-[86px]"
                    style="width: 0.8px; background-color: rgba(209, 213, 219, 0.8);"></div>
                <div class="hidden md:block absolute left-2/3 h-[86px]"
                    style="width: 0.8px; background-color: rgba(209, 213, 219, 0.8);"></div>
                <!-- Vision -->
                <div class="flex-1 px-6 py-6 md:py-0 max-md:border-b border-gray-300/80 font-heading">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#4b5563" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.355 4.5 12 4.5c4.647 0 8.58 3.013 9.964 7.178.07.207.07.437 0 .644C20.577 16.49 16.645 19.5 12 19.5c-4.647 0-8.58-3.013-9.964-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-xl font-bold text-color">Vision</h3>
                    </div>
                    <p class="text-[#443838] leading-relaxed font-regular">
                        {{ $about->about_vision ?? 'N/A' }}
                    </p>
                </div>

                <!-- Mission -->
                <div class="flex-1 px-6 py-6 md:py-0 max-md:border-b border-gray-300/80 font-heading">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#4b5563" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-bold text-color">Mission</h3>
                    </div>
                    <p class="text-[#443838] leading-relaxed font-regular">
                        {{ $about->about_mission ?? 'N/A' }}
                    </p>
                </div>

                <!-- Value -->
                <div class="flex-1 px-6 py-6 md:py-0 max-md:border-b border-gray-300/80 font-heading">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                            <circle cx="256" cy="160" r="128" fill="none" stroke="#4b5563" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="32" />
                            <path fill="none" stroke="#4b5563" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32"
                                d="M143.65 227.82L48 400l86.86-.42a16 16 0 0 1 13.82 7.8L192 480l88.33-194.32" />
                            <path fill="none" stroke="#4b5563" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32"
                                d="M366.54 224L464 400l-86.86-.42a16 16 0 0 0-13.82 7.8L320 480l-64-140.8" />
                            <circle cx="256" cy="160" r="64" fill="none" stroke="#4b5563" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="32" />
                        </svg>
                        <h3 class="text-xl font-bold text-color">Value</h3>
                    </div>
                    <p class="text-[#443838] leading-relaxed font-regular">
                        {{ $about->about_value ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Mission vision section end-->

<!-- We are registered start -->
<section class="mt-10">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px]">
        <h2 class="text-[30px] font-bold text-color text-center mb-10 font-heading">We Are Register With</h2>

        <div class="flex flex-wrap justify-center lg:justify-between gap-6">
            <!-- Government Registration -->
            @foreach ($registrations as $registration)
            <div class="w-[410px] h-full font-heading bg-white rounded-[8px] p-6 shadow-custom-combo mx-auto">
                <h3 class="text-[22px] font-semibold text-color mb-6 text-center">
                    {{ $registration->registered_to }}
                </h3>
                <div class="bg-[#F1FBF3] rounded-[4px] p-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-color font-medium">Registration No.</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M15.75 13a.75.75 0 0 0-.75-.75H9a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 .75-.75m0 4a.75.75 0 0 0-.75-.75H9a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 .75-.75" />
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M7 2.25A2.75 2.75 0 0 0 4.25 5v14A2.75 2.75 0 0 0 7 21.75h10A2.75 2.75 0 0 0 19.75 19V7.968c0-.381-.124-.751-.354-1.055l-2.998-3.968a1.75 1.75 0 0 0-1.396-.695zM5.75 5c0-.69.56-1.25 1.25-1.25h7.25v4.397c0 .414.336.75.75.75h3.25V19c0 .69-.56 1.25-1.25 1.25H7c-.69 0-1.25-.56-1.25-1.25z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="flex items-center justify-between">
                            <span
                                class="text-[#1971C2] font-bold tracking-tight">{{ $registration->registered_number }}</span>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!-- we are registered end -->

<!-- Our team section start -->
<div class="max-w-[1920px] mx-auto mt-10">
    <h2 class="text-[30px] font-bold text-color text-center mb-10 font-heading">Our Team</h2>
    {{-- @dd($teamsData) --}}
    <div x-data="{
            currentSlide: 0,
            teamMembers: @js($teamsData),
            get slidesToShow() {
                if (window.innerWidth < 768) return 1;
                if (window.innerWidth < 1024) return 2;
                return 4;
            },
            get maxSlide() {
                return Math.max(0, this.teamMembers.length - this.slidesToShow);
            },
            get shouldShowButtons() {
                return this.teamMembers.length > this.slidesToShow;
            },
            next() {
                if (this.currentSlide < this.maxSlide) {
                    this.currentSlide++;
                }
            },
            prev() {
                if (this.currentSlide > 0) {
                    this.currentSlide--;
                }
            },
            checkSlide() {
                if (this.currentSlide > this.maxSlide) {
                    this.currentSlide = this.maxSlide;
                }
            }
        }" x-init="checkSlide();
        window.addEventListener('resize', () => checkSlide());" class="relative">

        <!-- Previous Button -->
        <button x-show="shouldShowButtons" @click="prev()" :class="currentSlide === 0 ? 'opacity-50' : 'hover:bg-[#076166]'"
            class="absolute left-2 top-[40%] md:top-2/3 -translate-y-1/2 z-10 bg-[#00A1A5] text-white p-2.5 md:p-2.5 rounded-md shadow-lg transition-all md:left-12">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Carousel Container -->
        <div class="overflow-hidden mx-14 md:mx-16">
            <div class="flex transition-transform duration-500 ease-out"
                :style="`transform: translateX(-${currentSlide * (100 / slidesToShow)}%)`">

                <template x-for="(member, index) in teamMembers" :key="index">
                    <div class="w-full md:w-1/2 lg:w-1/4 flex-shrink-0 px-2 md:px-2">
                        <div
                            class="bg-white rounded-[8px] shadow-custom-combo p-6 md:p-8 text-center h-full border border-gray-100">
                            <!-- Profile Image -->
                            <div class="mb-6 flex justify-center">
                                <img :src="member.image" :alt="member.name"
                                    class="w-24 h-24 md:w-24 md:h-24 rounded-full object-cover">
                            </div>

                            <!-- Name -->
                            <h3 class="text-lg md:text-lg font-medium text-color mb-1 font-heading"
                                x-text="member.name">
                            </h3>

                            <!-- Role -->
                            <p class="text-gray-600 font-regular mb-2 text-sm md:text-sm font-heading"
                                x-text="member.role"></p>

                            <!-- Description -->
                            <p class="text[#646E82] text-xs md:text-sm leading-relaxed font-regular tracking-tight"
                                x-text="member.description"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Next Button -->
        <button x-show="shouldShowButtons" @click="next()" :class="currentSlide === maxSlide ? 'opacity-50' : 'hover:bg-[#076166]'"
            class="absolute right-2 top-[40%] md:top-2/3 -translate-y-1/2 z-10 bg-[#00A1A5] text-white p-2.5 md:p-2.5 rounded-md shadow-lg transition-all md:right-12">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Dots Indicator (Mobile Only) -->
        <div x-show="shouldShowButtons" class="flex justify-center mt-6 gap-2 md:hidden">
            <template x-for="(member, index) in teamMembers" :key="index">
                <button @click="currentSlide = index"
                    :class="currentSlide === index ? 'bg-teal-600 w-8' : 'bg-gray-300 w-2'"
                    class="h-2 rounded-full transition-all duration-300">
                </button>
            </template>
        </div>
    </div>
</div>

<!-- Our team section end -->

<!-- inquiry section start -->
<div class="py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Icon and Title -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-7 12h-2v-2h2zm1.8-5c-.3.4-.7.6-1.1.8c-.3.2-.4.3-.5.5c-.2.2-.2.4-.2.7h-2c0-.5.1-.8.3-1.1c.2-.2.6-.5 1.1-.8c.3-.1.5-.3.6-.5s.2-.5.2-.7c0-.3-.1-.5-.3-.7s-.5-.3-.8-.3s-.5.1-.7.2q-.3.15-.3.6h-2c.1-.7.4-1.3.9-1.7s1.2-.5 2.1-.5s1.7.2 2.2.6s.8 1 .8 1.7q.15.6-.3 1.2" />
            </svg>
            <h2 class="text-2xl md:text-xl font-bold text-color font-heading">Still Have Questions?</h2>
        </div>

        <!-- Description -->
        <p class="text-[#443838] text-base md:text-base mb-8 max-w-2xl mx-auto leading-relaxed font-heading">
            Our friendly team is here to help you with any questions or concerns you might have.
        </p>

        <!-- Button -->
        <button id="openModal"
            class="bg-[#00A1A5] hover:bg-[#076166] text-white font-heading text-base font-bold px-8 py-3.5 rounded-full transition-colors duration-300">
            Quick inquiry
        </button>
    </div>
</div>

<!-- Modal Overlay -->
<div id="modalOverlay"
    class=" fixed inset-0 bg-black font-heading bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <!-- Modal Container -->
    <div class="bg-white rounded-[8px] max-w-2xl w-full max-h-[90vh] overflow-y-auto relative">
        <!-- Close Button -->
        <button id="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Content -->
        <div class="p-6 md:p-6">
            <h3 class="text-xl md:text-2xl font-bold text-color mb-1">Send us a message</h3>
            <p class="text-[#646E82] mb-4 font-regular">Fill out the form and we'll respond within 24 hours</p>
            {{-- @dd(route('hostel.inquiryStore', $hostel->slug)); --}}
            <form action="{{ route('hostel.inquiryStore', $hostel->slug) }}" method="POST" enctype="multipart/form-data"
                id="contactForm">
                @csrf
                <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostel->id }}">
                <!-- Name and Email Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <div>
                        <label class="block text-color text-sm mb-2">Name</label>
                        <input type="text" name="full_name" id="full_name" placeholder="Your Name"
                            class="@error('full_name') is-invalid @enderror w-full px-4 py-3 text-sm font-heading font-light border border-[#E1DFDF] rounded-[4px] focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent">
                        @error('full_name')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-color text-sm mb-2">Email</label>
                        <input type="email" name="email_address" id="email_address" placeholder="your@email.com"
                            class="@error('email_address') is-invalid @enderror w-full px-4 py-3 text-sm font-heading font-light border border-[#E1DFDF] rounded-[4px] focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent">
                        @error('email_address')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Subject -->
                <div class="mb-2">
                    <label class="block text-color text-sm mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" placeholder="What is your enquiry about ?"
                        class="@error('subject') is-invalid @enderror w-full px-4 py-3 text-sm font-heading font-light border border-[#E1DFDF] rounded-[4px] focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent">
                    @error('subject')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Meal Options -->
                {{-- <div class="mb-2">
                        <label class="block text-color font-regular font-heading mb-2">Meal</label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="meal_radio" id="meal_radio" value="with"
                                    class="w-4 h-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                <span class="ml-2 text-color text-sm">With meal</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="meal_radio" id="meal_radio" value="without"
                                    class=" w-4 h-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                <span class="ml-2 text-color text-sm">Without meal</span>
                            </label>
                        </div>
                        @error('meal_radio')
                            <div class="text-red-500">{{ $message }}
        </div>
        @enderror
    </div> --}}

    <!-- Message -->
    <div class="mb-2">
        <label class="block text-color text-sm mb-2">Message</label>
        <textarea rows="5" name="message" id="message" placeholder="Tell us more about your enquiry ..."
            class="@error('message') is-invalid @enderror w-full px-4 py-3 text-sm font-heading font-light border border-[#E1DFDF] rounded-[4px] focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent"></textarea>
        @error('message')
        <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="bg-[#00A1A5] hover:bg-[#076166] font-heading text-white font-bold px-6 py-3 rounded-full transition-colors duration-300 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="m14 10l-3 3m9.288-9.969a.535.535 0 0 1 .68.681l-5.924 16.93a.535.535 0 0 1-.994.04l-3.219-7.242a.54.54 0 0 0-.271-.271l-7.242-3.22a.535.535 0 0 1 .04-.993z" />
        </svg>
        Send Message
    </button>
    </form>
</div>
</div>
</div>

<script>
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const contactForm = document.getElementById('contactForm');

    // Open modal
    openModal.addEventListener('click', () => {
        modalOverlay.classList.remove('hidden');
        modalOverlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        modalOverlay.classList.add('hidden');
        modalOverlay.classList.remove('flex');
        document.body.style.overflow = 'auto';
    });

    // Close modal when clicking outside
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    });

    // Handle form submission
    contactForm.addEventListener('submit', (e) => {
        // Don't prevent default or close modal - let Laravel handle validation
        // Modal will reopen automatically if there are errors
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    });

    // Reopen modal if there are validation errors
    <?php if ($errors->any()): ?>
        window.addEventListener('DOMContentLoaded', function() {
            modalOverlay.classList.remove('hidden');
            modalOverlay.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    <?php endif; ?>
</script>
<!-- inquiry section end -->
@endsection