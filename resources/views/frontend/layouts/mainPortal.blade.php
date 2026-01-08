<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hostel Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/toastr.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/src-assets/scss/plugins/sweetalert2.min.css') }}">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/src-assets/js/plugins/sweetalert2.min.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- x-cloak style -->
    @vite(['resources/css/mainPortal.css', 'resources/js/app.js'])
    <style>
    [x-cloak] {
        display: none !important;
    }

    .slider-container {
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .slider-container::-webkit-scrollbar {
        display: none;
    }

    .card-image {
        transition: opacity 0.2s ease-in-out;
    }

    .dot {
        transition: all 0.3s ease;
    }

    .slider-container {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        pointer-events: none;
    }
    </style>
</head>

<body class="bg-[#F9FAFB] min-h-screen flex flex-col">
    <div class="sticky top-0 z-[999]">
        @include('frontend.layouts.mainPortalNavbar')
    </div>
    <main>
        @yield('body')
    </main>
    <div>
        @include('frontend.layouts.mainPortalFooter')
    </div>

    <!-- Top Ranking Hostel Js  -->
    <script>
    let currentIndex = 0;
    const carousel = document.getElementById('carousel');
    const cards = carousel.children;

    function getVisibleCards() {
        if (window.innerWidth >= 1600) return 4;
        if (window.innerWidth >= 1280) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }

    function updateCarousel() {
        const visibleCards = getVisibleCards();
        const maxIndex = cards.length - visibleCards;
        if (currentIndex > maxIndex) currentIndex = maxIndex;
        if (currentIndex < 0) currentIndex = 0;

        const cardWidth = cards[0].offsetWidth;
        const gap = 16;
        const offset = -(currentIndex * (cardWidth + gap));
        carousel.style.transform = `translateX(${offset}px)`;
    }

    function nextCard() {
        const visibleCards = getVisibleCards();
        const maxIndex = cards.length - visibleCards;
        currentIndex = (currentIndex + 1) > maxIndex ? 0 : currentIndex + 1;
        updateCarousel();
    }

    function prevCard() {
        const visibleCards = getVisibleCards();
        const maxIndex = cards.length - visibleCards;
        currentIndex = (currentIndex - 1) < 0 ? maxIndex : currentIndex - 1;
        updateCarousel();
    }

    // Image slider functionality
    function changeImage(btn, direction) {
        const slider = btn.closest('.image-slider');
        const slides = slider.querySelector('.image-slides');
        const dots = slider.querySelectorAll('.dot');
        const totalImages = dots.length;

        let currentImg = 0;
        for (let i = 0; i < dots.length; i++) {
            if (dots[i].classList.contains('active')) {
                currentImg = i;
                break;
            }
        }

        currentImg = (currentImg + direction + totalImages) % totalImages;

        slides.style.transform = `translateX(-${currentImg * 100}%)`;

        dots.forEach((dot, idx) => {
            if (idx === currentImg) {
                dot.classList.add('active');
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-white');
            } else {
                dot.classList.remove('active');
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/50');
            }
        });
    }

    window.addEventListener('resize', updateCarousel);
    updateCarousel();

    // Add keyboard event listener
    document.addEventListener('keydown', function(e) {
        // Check if user pressed left arrow key with Ctrl
        if (e.ctrlKey && e.key === 'ArrowLeft') {
            e.preventDefault();
            prevCard();
        }
        // Check if user pressed right arrow key with Ctrl
        if (e.ctrlKey && e.key === 'ArrowRight') {
            e.preventDefault();
            nextCard();
        }
    });
    </script>

    <script src="{{ asset('assets/dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>
    <script>
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type') }}"
    switch (type) {
        case 'info':
            toastr.options.timeOut = 10000;
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.options.timeOut = 10000;
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'warning':
            toastr.options.timeOut = 10000;
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.options.timeOut = 1000000;
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

    function toastMessage(notification) {
        const type = notification["alert-type"];
        const message = notification.message;
        switch (type) {
            case 'info':
                toastr.options.timeOut = 10000;
                toastr.info(message);
                break;
            case 'success':
                toastr.options.timeOut = 10000;
                toastr.success(message);
                break;
            case 'warning':
                toastr.options.timeOut = 10000;
                toastr.warning(message);
                break;
            case 'error':
                toastr.options.timeOut = 10000;
                toastr.error(message);
                break;
        }
    }
    </script>

    <!-- Top Ranking Hostel End Js -->

    @stack('scripts')
</body>

</html>