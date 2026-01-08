@extends('frontend.layouts.mainPortal')

@section('body')
<!-- About Banner start -->
<section class="bg-[#0d1b2d] w-full h-[70px] flex items-center sticky top-[88px] z-10">
    <div
        class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
        <!-- Left Section -->
        <h1 class="text-2xl sm:text-[20px] text-white  font-bold text-color mb-2 sm:mb-0 font-heading">About Us</h1>
        <!-- Right Section (Breadcrumb) -->
        <nav class="text-sm font-medium text-color font-heading flex items-center space-x-0.5">
            <a href="{{ route('home') }}" class="hover:underline text-white/80 hover:text-white font-heading">Home</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="20" height="20" viewBox="0 0 48 48">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                    d="m19 12l12 12l-12 12" />
            </svg>
            <span class="sub-text font-heading text-white font-regular">About</span>
        </nav>
    </div>
</section>
<!-- About Banner end -->
@if (isset($about))
<!-- About us content Start -->
<section class="max-w-5xl mx-auto text-center px-6 mt-[70px]">
    <h2 class="text-xl md:text-2xl font-heading font-bold text-color">
        {{ $about->about_title }}
    </h2>

    <p class="text-body leading-7! text-sm font-heading font-regular md:text-base mt-5 text-justify">
        {!! $about->about_description !!}
    </p>
</section>
<!-- About Us content End-->


<!-- How it works section start -->
<section class="bg-[#f2f6fa] py-16 px-4 sm:px-6 lg:px-8 mt-[70px]">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-xl sm:text-2xl font-bold text-color">How It Works</h2>
            <p class="sub-text font-heading font-regular text-base mt-3.5">Your journey from booking to checkout is
                seamless and hassle-free</p>
        </div>

        <!-- Steps Container -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mt-5">
            <!-- Step 01 -->
            <div class="relative pt-8">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2">
                    <div
                        class="bg-white border-2 border-[#1D56E9] rounded-full w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-medium font-heading text-color">01</span>
                    </div>
                </div>
                <div class="bg-[#FAF9F9] rounded-lg border-2 border-[#1D56E9] p-8 pt-12 h-full">
                    <div class="text-center">
                        <h3 class="text-xl font-medium font-heading text-color mb-2">Discover</h3>
                        <p class="text-body font-heading text-base font-light">Explore our comprehensive range of
                            services and
                            solutions tailored to meet your unique needs and business objectives.</p>
                    </div>
                </div>
            </div>

            <!-- Step 02 -->
            <div class="relative pt-8">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2">
                    <div
                        class="bg-white border-2 border-[#1D56E9] rounded-full w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-medium font-heading text-color">02</span>
                    </div>
                </div>
                <div class="bg-[#FAF9F9] rounded-lg border-2 border-[#1D56E9] p-8 pt-12 h-full">
                    <div class="text-center">
                        <h3 class="text-xl font-medium font-heading text-color mb-2">Collaborate</h3>
                        <p class="text-body font-heading text-base font-light">Work closely with our expert team to
                            develop customized strategies that align with your vision and goals.</p>
                    </div>
                </div>
            </div>

            <!-- Step 03 -->
            <div class="relative pt-8">
                <div class="absolute top-0  left-1/2 transform -translate-x-1/2">
                    <div
                        class="bg-white border-2 border-[#1D56E9] rounded-full w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-medium font-heading text-color">03</span>
                    </div>
                </div>
                <div class="bg-[#FAF9F9] rounded-lg border-2 border-[#1D56E9] p-8 pt-12 h-full">
                    <div class="text-center">
                        <h3 class="text-xl font-medium font-heading text-color mb-2">Succeed</h3>
                        <p class="text-body font-heading text-base font-light">Achieve measurable results and
                            sustainable growth through our proven methodologies and ongoing support.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- How it works section end -->

<!--  Mission Vision section start -->
<section class=" px-4 sm:px-6 lg:px-6 mt-[70px]">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Our Mission -->
            <div class="bg-white rounded-lg box-shadow p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-color font-heading">Our Mission</h2>
                <p class="text-body font-heading font-light text-base leading-relaxed text-justify mt-2">
                    {{ $about->about_mission }}
                </p>
            </div>

            <!-- Our Vision -->
            <div class="bg-white rounded-lg box-shadow p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-color font-heading">Our Vision</h2>
                <p class="text-body font-heading font-light text-base leading-relaxed text-justify mt-2">
                    {{ $about->about_vision }}
                </p>
            </div>
        </div>
    </div>
</section>
<!--  Mission vision section end -->

<!-- Our Values section start -->
<section class="bg-[#f2f6fa]/80 py-16 px-4 sm:px-6 lg:px-20 mt-[70px]">
    <div class="max-w-8xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-color font-heading">Our Values</h2>
            <p class="sub-text font-heading font-regular text-base mt-3.5">What makes our hostel special and
                welcoming
            </p>
        </div>

        <!-- Values Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <!-- Integrity -->
            @foreach ($about->values as $value)
            <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
                <div class="rounded-sm w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('storage/images/valueImages/' . $value->value_icon) }}"
                        alt="{{ $value->value_title }}">
                </div>
                <h3 class="text-lg font-medium text-color mt-2">{{ $value->value_title }}</h3>
                <p class="text-body leading-[25px] mt-2 font-heading font-light">{{ $value->value_description }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--  Our Values section end-->

<!-- Our Promise section start-->
<section class="py-16 px-4 sm:px-6 lg:px-20">
    <div class="max-w-8xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Left Side - Image -->

            <div class="relative">
                @if (isset($systemConfigs['about_image']) && $systemConfigs['about_image'])
                <img src="{{ asset('storage/images/adminConfigImages/' . $systemConfigs['about_image']) }}"
                    alt="Hostel room with bunk beds" class="w-full h-full object-cover rounded-lg">
                <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>
                @endif
            </div>

            <!-- Right Side - Content -->
            <div class="flex flex-col justify-center">
                <!-- Header -->
                <div class=" mb-5">
                    <h2 class="text-2xl font-bold text-color text-center font-heading">Our Promise</h2>
                    <p class="sub-text font-heading font-regular text-base mt-3.5 text-center">We're committed to
                        making
                        your stay
                        memorable and
                        comfortable
                    </p>
                </div>

                <!-- Features List -->
                <div class="space-y-4">
                    <!-- Affordable Stays -->
                    <div class="bg-white rounded-lg border border-color box-shadow p-6 flex items-center gap-3">
                        <div class="bg-[#4490D9] rounded-sm w-10 h-10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 2.25a.75.75 0 0 1 .75.75v1.25H17a.75.75 0 0 1 0 1.5h-4.25v5.5h1.75a4.25 4.25 0 0 1 0 8.5h-1.75V21a.75.75 0 0 1-1.5 0v-1.25H6a.75.75 0 0 1 0-1.5h5.25v-5.5H9.5a4.25 4.25 0 0 1 0-8.5h1.75V3a.75.75 0 0 1 .75-.75m-.75 3.5H9.5a2.75 2.75 0 0 0 0 5.5h1.75zm1.5 7v5.5h1.75a2.75 2.75 0 1 0 0-5.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg text-color font-medium">Affordable Stays</h3>
                            <p class="sub-text font-heading font-regular text-sm">Budget-friendly prices for
                                backpackers</p>
                        </div>
                    </div>

                    <!-- Secure & reliable services -->
                    <div class="bg-white rounded-lg border border-color box-shadow p-6 flex items-center gap-3">
                        <div class="bg-[#4490D9] rounded-sm w-10 h-10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M22 3.94L12 .44L2 3.94V12c0 4.127 2.534 7.012 4.896 8.803a19.8 19.8 0 0 0 4.65 2.595q.17.064.342.122l.112.04l.114-.04a14 14 0 0 0 .65-.244a19.7 19.7 0 0 0 4.34-2.473C19.467 19.012 22 16.127 22 12zM11.001 15.415L6.76 11.172l1.414-1.415l2.828 2.829l5.657-5.657l1.415 1.414z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg text-color font-medium">Secure & reliable services</h3>
                            <p class="sub-text font-heading font-regular text-sm">Secure lockers and spotless
                                facilities
                            </p>
                        </div>
                    </div>

                    <!-- Fast Booking Process -->
                    <div class="bg-white rounded-lg border border-color box-shadow p-6 flex items-center gap-3">
                        <div class="bg-[#4490D9] rounded-sm w-10 h-10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill="currentColor" d="M11 15H6l7-14v8h5l-7 14z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg text-color font-medium">Fast Booking Process</h3>
                            <p class="sub-text font-heading font-regular text-sm">Book your bed in just a few
                                clicks
                            </p>
                        </div>
                    </div>

                    <!-- 24/7 Support -->
                    <div class="bg-white rounded-lg border border-color box-shadow p-6 flex items-center gap-3">
                        <div class="bg-[#4490D9] rounded-sm w-10 h-10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M256 48C141.13 48 48 141.13 48 256s93.13 208 208 208s208-93.13 208-208S370.87 48 256 48m96 240h-96a16 16 0 0 1-16-16V128a16 16 0 0 1 32 0v128h80a16 16 0 0 1 0 32" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg text-color font-medium">24/7 Support</h3>
                            <p class="sub-text font-heading font-regular text-sm">Our friendly staff is always here
                                to
                                help
                            </p>
                        </div>
                    </div>

                    <!-- 100% User Satisfaction -->
                    <div class="bg-white rounded-lg border border-color box-shadow p-6 flex items-center gap-3">
                        <div class="bg-[#4490D9] rounded-sm w-10 h-10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 17.275l-4.15 2.5q-.275.175-.575.15t-.525-.2t-.35-.437t-.05-.588l1.1-4.725L3.775 10.8q-.25-.225-.312-.513t.037-.562t.3-.45t.55-.225l4.85-.425l1.875-4.45q.125-.3.388-.45t.537-.15t.537.15t.388.45l1.875 4.45l4.85.425q.35.05.55.225t.3.45t.038.563t-.313.512l-3.675 3.175l1.1 4.725q.075.325-.05.588t-.35.437t-.525.2t-.575-.15z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg text-color font-medium">100% User Satisfaction</h3>
                            <p class="sub-text font-heading font-regular text-sm">Your comfort is our top priority
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Our Promise section end -->
@endif
<!-- FAQ's section start -->
<section class=" px-4 sm:px-6 lg:px-20 mt-[70px]">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-color text-center font-heading">Frequently Asked Questions</h2>
            <p class="sub-text font-heading font-regular text-base mt-3.5 text-center">Everything you need to know
                about
                staying with us</p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4 mt-5">
            <!-- Question 1 - Open by default -->
            @foreach ($faqs as $faq)
            <div class="bg-white rounded-lg border border-color box-shadow overflow-hidden">
                <button onclick="toggleAccordion(this)"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-[#7790c2]/5 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <span class="text-base font-medium font-heading text-color">{{ $faq->faq_question }}</span>
                        <span
                            class="px-3 py-1 text-xs font-heading font-regular bg-[#e5eeff]/60 text-[#4e81f2] rounded-full w-fit">{{ $faq->category->category_name }}</span>
                    </div>
                    <span
                        class="plus-icon text-2xl font-light text-gray-900 shrink-0 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" d="M6 12h6m6 0h-6m0 0V6m0 6v6" />
                        </svg>
                    </span>
                </button>
                <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-5 pb-6 font-heading font-light text-body mt-4 leading-[25px] text-base">
                        {{ $faq->faq_answer }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- View More Button -->
        <div class="text-center mt-8">
            <a href="{{ route('faq') }}">
                <button
                    class="font-heading text-sm rounded-[50px] px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0] nline-flex hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0]">
                    View More FAQ's
                </button>
            </a>
            <!-- <a href="{{ route('faq') }}">
                <button
                    class="button-color text-color hover:bg-[#023be4] hover:text-[white] border border-color font-semibold px-8 py-3 rounded-full transition-colors duration-300 ">
                    View More FAQs
                </button>
            </a> -->
        </div>
    </div>
</section>

<script>
    function toggleAccordion(button) {
        const item = button.parentElement;
        const content = item.querySelector('.accordion-content');
        const icon = button.querySelector('.plus-icon');
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

        // Close all other accordions
        document.querySelectorAll('.accordion-content').forEach(otherContent => {
            if (otherContent !== content) {
                otherContent.style.maxHeight = '0px';
                const otherIcon = otherContent.parentElement.querySelector('.plus-icon');
                otherIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle current accordion
        if (isOpen) {
            content.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            icon.style.transform = 'rotate(45deg)';
        }
    }

    // Open first accordion by default
    window.addEventListener('DOMContentLoaded', () => {
        const firstAccordion = document.querySelector('.bg-white button');
        toggleAccordion(firstAccordion);
    });
</script>
<!-- FAQ's section end -->

@endsection