<!-- Footer Section -->
<footer class="bg-[#000719] text-gray-300 px-6 md:px-12 lg:px-20 xl:px-20 py-10 mt-[70px]">
    <div class="max-w-8xl mx-auto">

        <!-- Top Section: Logo + Social -->
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                @if (isset($systemConfigs['footer_logo']) && $systemConfigs['footer_logo'])
                    <img src="{{ asset('storage/images/adminConfigImages/' . $systemConfigs['footer_logo']) }}"
                        alt="OmWay Technologies Logo" class="w-[150px] h-full">
                @endif

            </div>
            <!-- Social Icons -->
            <div class="flex items-center gap-3 mt-4 sm:mt-0">
                @if (isset($systemConfigs['social_facebook']) && $systemConfigs['social_facebook'])
                    <a href="{{ $systemConfigs['social_facebook'] }}"
                        class="bg-white hover:bg-[#163a8d] text-black hover:text-white w-9 h-9 flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 2.04c-5.5 0-10 4.49-10 10.02c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89c1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02" />
                        </svg>
                    </a>
                @endif
                @if (isset($systemConfigs['social_whatsapp']) && $systemConfigs['social_whatsapp'])
                    <a href="{{ $systemConfigs['social_whatsapp'] }}"
                        class="bg-white hover:bg-[#163a8d] text-black hover:text-white w-9 h-9 flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path
                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor"
                                    d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636" />
                            </g>
                        </svg>
                    </a>
                @endif
                @if (isset($systemConfigs['social_instagram']) && $systemConfigs['social_instagram'])
                    <a href="{{ $systemConfigs['social_instagram'] }}"
                        class="bg-white hover:bg-[#163a8d] text-black hover:text-white w-9 h-9 flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M13.028 2c1.125.003 1.696.009 2.189.023l.194.007c.224.008.445.018.712.03c1.064.05 1.79.218 2.427.465c.66.254 1.216.598 1.772 1.153a4.9 4.9 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.012.266.022.487.03.712l.006.194c.015.492.021 1.063.023 2.188l.001.746v1.31a79 79 0 0 1-.023 2.188l-.006.194c-.008.225-.018.446-.03.712c-.05 1.065-.22 1.79-.466 2.428a4.9 4.9 0 0 1-1.153 1.772a4.9 4.9 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465l-.712.03l-.194.006c-.493.014-1.064.021-2.189.023l-.746.001h-1.309a78 78 0 0 1-2.189-.023l-.194-.006a63 63 0 0 1-.712-.031c-1.064-.05-1.79-.218-2.428-.465a4.9 4.9 0 0 1-1.771-1.153a4.9 4.9 0 0 1-1.154-1.772c-.247-.637-.415-1.363-.465-2.428l-.03-.712l-.005-.194A79 79 0 0 1 2 13.028v-2.056a79 79 0 0 1 .022-2.188l.007-.194c.008-.225.018-.446.03-.712c.05-1.065.218-1.79.465-2.428A4.9 4.9 0 0 1 3.68 3.678a4.9 4.9 0 0 1 1.77-1.153c.638-.247 1.363-.415 2.428-.465c.266-.012.488-.022.712-.03l.194-.006a79 79 0 0 1 2.188-.023zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10m0 2a3 3 0 1 1 .001 6a3 3 0 0 1 0-6m5.25-3.5a1.25 1.25 0 0 0 0 2.5a1.25 1.25 0 0 0 0-2.5" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-color opacity-[0.3] my-6"></div>

        <!-- Middle Section: Paragraph (left) + Links (right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14">
            <!-- Paragraph / Description (spans 7 of 12 on large screens) -->
            <div class="lg:col-span-7 text-[#9BA1B6] text-sm leading-[25px] font-heading text-justify font-light">
                {{ $systemConfigs['footer_description'] ?? '' }}
            </div>

            <!-- Links Columns (spans 5 of 12 on large screens) -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-3 gap-6 text-[#9BA1B6]">
                <div>
                    <h3 class="text-white text-base font-medium mb-2 font-heading">Useful Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-white text-sm font-heading font-regular">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blog') }}" class="hover:text-white text-sm font-heading font-regular">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}" class="hover:text-white text-sm font-heading font-regular">
                                FAQ’s
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hostel') }}" class="hover:text-white text-sm font-heading font-regular">
                                All Hostels
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white text-base font-medium mb-2 font-heading">For Owners</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}#hostelListing"
                                class="hover:text-white text-sm font-heading font-regular">
                                List Your Property
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-white text-sm font-heading font-regular">
                                Refer an owner
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white text-base font-medium mb-2 font-heading">More Information</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white text-sm font-heading font-regular">Help
                                Center</a></li>
                        <li><a href="#" class="hover:text-white text-sm font-heading font-regular">Privacy
                                Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-color opacity-[0.3] my-6"></div>

        <!-- Bottom: Copyright -->
        <div class="pt-1 text-[#9BA1B6] text-xs font-heading flex flex-col sm:flex-row justify-between items-center">
            <p>© {{ now()->year }} HostelHub. All rights reserved. | Proudly serving students across Nepal</p>
            <p class="mt-1 text-[#9BA1B6] sm:mt-0">
                Developed by
                <a href="https://omwaytechnologies.com/" class="text-white">
                    OmWay Technologies
                </a>
            </p>
        </div>
    </div>
</footer>
