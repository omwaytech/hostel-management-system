<!-- Navigation Bar -->
<nav class="bg-[#1F1F1F] fixed w-full z-50 top-0 left-0">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px]">
        <div class="flex items-center justify-between h-[88px]">
            <!-- Logo -->
            <a href="{{ route('hostel.index', $hostel->slug) }}" class="flex items-center">
                @if (isset($hostelConfigs['navbar_logo']) && $hostelConfigs['navbar_logo'])
                    <img src="{{ asset('storage/images/hostelConfigImages/' . $hostelConfigs['navbar_logo']) }}"
                        class=" w-40 h-full object-contain" alt="{{ $hostel->name }} Logo">
                @else
                    <img src="{{ asset('assets/images/hostelPortal/logo.png') }}" class=" w-40 h-full object-contain"
                        alt="MSH Logo">
                @endif
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-3">

                <a href="{{ route('hostel.index', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.index') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    Home
                </a>

                <a href="{{ route('hostel.aboutUs', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.aboutUs') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    About us
                </a>

                <a href="{{ route('hostel.room', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.room') || request()->routeIs('hostel.roomdetail') || request()->routeIs('hostel.checkout') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    Rooms
                </a>

                <a href="{{ route('hostel.gallery', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.gallery') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    Gallery
                </a>

                <a href="{{ route('hostel.blog', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.blog') || request()->routeIs('hostel.blogdetails') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    News & Blogs
                </a>

                <a href="{{ route('hostel.contact', $hostel->slug) }}"
                    class="relative font-heading px-4 py-2 text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.contact') ? 'text-white bg-color' : 'text-white hover:text-white hover-bg-color' }}">
                    Contact Us
                </a>
            </div>

            <!-- Sign In Button -->
            <div class="hidden md:flex items-center">

                <a href="{{ route('hostel.signin', $hostel->slug) }}"
                    class="text-white bg-color font-heading  hover:bg-[white] hover:text-[black] px-4 py-2.5 rounded-[50px] text-sm font-bold transition-colors duration-300">
                    Sign in
                </a>
            </div>
            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button type="button"
                    class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#1F625F] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1F625F]"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu Open Icon -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden mobile-menu hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            <a href="{{ route('hostel.index', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-[2px] transition-all duration-300 {{ request()->routeIs('hostel.index') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                Home
            </a>

            <a href="{{ route('hostel.aboutUs', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-md transition-all duration-300 {{ request()->routeIs('hostel.aboutUs') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                About us
            </a>

            <a href="{{ route('hostel.room', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-md transition-all duration-300 {{ request()->routeIs('hostel.room') || request()->routeIs('hostel.roomdetail') || request()->routeIs('hostel.checkout') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                Rooms
            </a>

            <a href="{{ route('hostel.gallery', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-md transition-all duration-300 {{ request()->routeIs('hostel.gallery') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                Gallery
            </a>

            <a href="{{ route('hostel.blog', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-md transition-all duration-300 {{ request()->routeIs('hostel.blog') || request()->routeIs('hostel.blogdetails') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                News & Blogs
            </a>

            <a href="{{ route('hostel.contact', $hostel->slug) }}"
                class="block px-3 py-2 font-heading text-sm font-bold rounded-md transition-all duration-300 {{ request()->routeIs('hostel.contact') ? 'text-white bg-color' : 'text-black hover:bg-gray-50' }}">
                Contact Us
            </a>
            <div class="px-3 py-2">

                <a href="{{ route('hostel.signin', $hostel->slug) }}"
                    class="block text-center font-heading text-white bg-color  hover:text-[white] px-6 py-2.5 rounded-[50px] text-sm font-bold transition-colors duration-300">
                    Sign in
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.querySelector('.mobile-menu-button').addEventListener('click', function() {
        document.querySelector('.mobile-menu').classList.toggle('hidden');
    });
</script>
