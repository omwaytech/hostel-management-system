@extends('frontend.layouts.hostelPortal')
@section('body')
    <!-- Contact Banner start -->
    <section class="bg-[#E5E4E2] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Contact Us</h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">Contact Us</span>
            </nav>
        </div>
    </section>
    <!-- Contact Banner end -->

    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-10">

        <!-- Left: Contact Form -->
        <div class="bg-white rounded-lg shadow-custom-combo p-6">
            <h2 class="text-xl font-bold mb-4 font-heading">Leave your Message</h2>
            <form action="{{ route('hostel.contactStore', $hostel->slug) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <input type="hidden" name="hostel_id" id="hostel_id" value="{{ $hostel->id }}">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-regular font-heading text-color">First Name*</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Enter your first name"
                            class="@error('first_name') is-invalid @enderror mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none" />
                        @error('first_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-regular font-heading text-color">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Enter your last name"
                            class="@error('last_name') is-invalid @enderror mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none" />
                        @error('last_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-regular font-heading text-color">Email Address *</label>
                        <input type="email" name="email_address" id="email_address" placeholder="youremail@example.com"
                            class="@error('email_address') is-invalid @enderror mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none" />
                        @error('email_address')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-regular font-heading text-color">Phone Number *</label>
                        <input type="number" name="phone_number" id="phone_number" placeholder="+977 98XXXXXXXX"
                            class="@error('phone_number') is-invalid @enderror mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none" />
                        @error('phone_number')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm font-regular font-heading text-color">Message *</label>
                    <textarea placeholder="Write your message" rows="4" name="message" id="message"
                        class="@error('message') is-invalid @enderror w-full border border-gray-300 rounded-md p-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none"></textarea>
                    @error('message')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-[#00A1A5] hover:bg-[#076166] font-heading text-white text-base font-bold px-5 py-3 rounded-full">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Right: Contact Info -->
        <div>
            <h2 class="text-2xl font-semibold mb-6 font-heading text-color">Don’t hesitate to contact us</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Office -->
                @if (isset($hostelConfigs['physical_address']) && $hostelConfigs['physical_address'])
                    <div class="flex items-center gap-3 bg-white rounded-[4px] p-4 shadow-custom-combo">
                        <div class="w-10 h-10 rounded-full bg-[#E3E9FA] flex items-center justify-center text-[#4154FB]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15a6 6 0 1 0 0-12a6 6 0 0 0 0 12m0 0v6M9.5 9A2.5 2.5 0 0 1 12 6.5" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium font-heading text-color font-base">Office</p>
                            <p class="text-sm sub-text font-heading font-regular">{{ $hostelConfigs['physical_address'] }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Phone -->
                @if (isset($hostelConfigs['contact_phone_1']) && $hostelConfigs['contact_phone_1'])
                    <div class="flex items-center gap-3 bg-white rounded-[4px] p-4 shadow-custom-combo">
                        <div class="w-10 h-10 rounded-full bg-[#FFEDEA] flex items-center justify-center text-[#F0B24C]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.28-.28.67-.36 1.02-.25c1.12.37 2.32.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium font-heading text-color font-base">Phone</p>
                            <p class="text-sm sub-text font-heading font-regular">{{ $hostelConfigs['contact_phone_1'] }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Work Hours -->
                <div class="flex items-center gap-3 bg-white rounded-[4px] p-4 shadow-custom-combo">
                    <div class="w-10 h-10 rounded-full bg-[#F0E6FC] flex items-center justify-center text-[#892FC1]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                            <path fill="currentColor"
                                d="M16 2C8.4 2 2 8.4 2 16s6.4 14 14 14s14-6.4 14-14S23.6 2 16 2m4.587 20L15 16.41V7h2v8.582l5 5.004z" />
                            <path fill="none" d="M20.587 22L15 16.41V7h2v8.582l5 5.005z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium font-heading text-color font-base">Work Hours</p>
                        <p class="text-sm sub-text font-heading font-regular">Everyday 09am - 05pm</p>
                    </div>
                </div>

                <!-- Email -->

                <div class="flex items-center gap-3 bg-white rounded-[4px] p-4 shadow-custom-combo">
                    <div class="w-10 h-10 rounded-full bg-[#CBF6C8] flex items-center justify-center text-[#26D510]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M448.67 154.45L274.1 68.2a41.1 41.1 0 0 0-36.2 0L63.33 154.45A55.6 55.6 0 0 0 32 204.53v184.61c0 30.88 25.42 56 56.67 56h334.66c31.25 0 56.67-25.12 56.67-56V204.53a55.6 55.6 0 0 0-31.33-50.08M252.38 96.82a8.22 8.22 0 0 1 7.24 0L429 180.48l-172 85a8.22 8.22 0 0 1-7.24 0L80.35 181.81Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium font-heading text-color font-base">Email</p>
                        <p class="text-sm sub-text font-heading font-regular">{{ session('active_hostel')->email }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mt-6 pt-6 border-t border-[#EAECF0]">
                <div class="flex items-center justify-between">
                    <p class="text-base font-heading font-semibold text-color">Follow Us:</p>
                    <div class="flex gap-3">
                        @if (isset($hostelConfigs['social_facebook']) && $hostelConfigs['social_facebook'])
                            <a href="{{ $hostelConfigs['social_facebook'] }}" target="_blank"
                                class="w-8 h-8 rounded-full bg-[#076166] flex items-center justify-center text-white hover:bg-[#003135] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <g fill="none">
                                        <path
                                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M13.5 21.888C18.311 21.164 22 17.013 22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 5.013 3.689 9.165 8.5 9.888V15H9a1.5 1.5 0 0 1 0-3h1.5v-2A3.5 3.5 0 0 1 14 6.5h.5a1.5 1.5 0 0 1 0 3H14a.5.5 0 0 0-.5.5v2H15a1.5 1.5 0 0 1 0 3h-1.5z" />
                                    </g>
                                </svg>
                            </a>
                        @endif
                        @if (isset($hostelConfigs['social_whatsapp']) && $hostelConfigs['social_whatsapp'])
                            <a href="{{ $hostelConfigs['social_whatsapp'] }}" target="_blank"
                                class="w-8 h-8 rounded-full bg-[#076166] flex items-center justify-center text-white hover:bg-[#003135] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636" />
                                    </g>
                                </svg>
                            </a>
                        @endif
                        @if (isset($hostelConfigs['social_instagram']) && $hostelConfigs['social_instagram'])
                            <a href="{{ $hostelConfigs['social_instagram'] }}" target="_blank"
                                class="w-8 h-8 rounded-full bg-[#076166] flex items-center justify-center text-white hover:bg-[#003135] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13.028 2c1.125.003 1.696.009 2.189.023l.194.007c.224.008.445.018.712.03c1.064.05 1.79.218 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.012.266.022.487.03.712l.006.194c.015.492.021 1.063.023 2.188l.001.746v1.31a79 79 0 0 1-.023 2.188l-.006.194c-.008.225-.018.446-.03.712c-.05 1.065-.22 1.79-.466 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465l-.712.03l-.194.006c-.493.014-1.064.021-2.189.023l-.746.001h-1.309a78 78 0 0 1-2.189-.023l-.194-.006a63 63 0 0 1-.712-.031c-1.064-.05-1.79-.218-2.428-.465a4.9 4.9 0 0 1-1.771-1.153a4.9 4.9 0 0 1-1.154-1.772c-.247-.637-.415-1.363-.465-2.428l-.03-.712l-.005-.194A79 79 0 0 1 2 13.028v-2.056a79 79 0 0 1 .022-2.188l.007-.194c.008-.225.018-.446.03-.712c.05-1.065.218-1.79.465-2.428A4.9 4.9 0 0 1 3.68 3.678a4.9 4.9 0 0 1 1.77-1.153c.638-.247 1.363-.415 2.428-.465c.266-.012.488-.022.712-.03l.194-.006a79 79 0 0 1 2.188-.023zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10m0 2a3 3 0 1 1 .001 6a3 3 0 0 1 0-6m5.25-3.5a1.25 1.25 0 0 0 0 2.5a1.25 1.25 0 0 0 0-2.5" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($hostelConfigs['google_map_embed']) && $hostelConfigs['google_map_embed'])
        <div class="mt-12 h-96 md:h-96 lg:h-96 -mb-10 overflow-hidden">
            <iframe src="{{ $hostelConfigs['google_map_embed'] }}" class="w-full h-full border-0" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    @else
        <div class="mt-12 h-96 md:h-96 lg:h-96 -mb-10 overflow-hidden">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113032.64937781877!2d85.2911368!3d27.7089603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb198a307baabf%3A0xb5137c1bf18db1ea!2sKathmandu%2C%20Nepal!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    @endif
@endsection
