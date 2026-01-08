@extends('frontend.layouts.hostelPortal')

@section('body')
    <!-- Room Banner start -->
    <section class="bg-[#E5E4E2] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Gallery</h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">Gallery</span>
            </nav>
        </div>
    </section>
    <!-- Room Banner end -->
    <!-- Main Container -->
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <div id="header" class="mb-6">
            <button id="backBtn"
                class="hidden flex text-sm border border-[#E1DFDF] px-4 py-2 hover-bg-color hover:text-white hover-text-color items-center text-gray-600  mb-4 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
                </svg>
                Back to Albums
            </button>
            <h1 id="pageTitle" class="text-lg md:text-xl font-bold text-color font-heading mt-6">Hostel Gallery Albums</h1>
        </div>

        <!-- Albums Grid -->
        <div id="albumsView">
            <div id="albumsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Album cards will be inserted here -->
            </div>
        </div>

        <!-- Photos Grid (Hidden by default) -->
        <div id="photosView" class="hidden">
            <div id="photosGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Photo items will be inserted here -->
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div id="lightbox" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4">
            <button id="closeLightbox" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <button id="prevPhoto" class="absolute left-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextPhoto" class="absolute right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <img id="lightboxImg" class="max-w-full max-h-full object-contain" src="" alt="">
        </div>
    </div>

    <script>
        // Dynamic data from Laravel
        const albums = @json($albums);

        let currentAlbum = null;
        let currentPhotoIndex = 0;

        // DOM elements
        const albumsView = document.getElementById('albumsView');
        const photosView = document.getElementById('photosView');
        const albumsGrid = document.getElementById('albumsGrid');
        const photosGrid = document.getElementById('photosGrid');
        const backBtn = document.getElementById('backBtn');
        const pageTitle = document.getElementById('pageTitle');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const closeLightbox = document.getElementById('closeLightbox');
        const prevPhoto = document.getElementById('prevPhoto');
        const nextPhoto = document.getElementById('nextPhoto');

        // Render albums
        function renderAlbums() {
            albumsGrid.innerHTML = albums.map(album => `
                <div class="bg-white rounded-[8px] overflow-hidden shadow-custom-combo transition duration-300 cursor-pointer transform hover:saturate-100"
                     onclick="openAlbum(${album.id})">
                    <div class="relative aspect-[4/2] overflow-hidden">
                        <img src="${album.coverImage}"
                             alt="${album.title}"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h2 class="text-xl font-heading font-medium text-color mb-1">${album.title}</h2>
                        <p class="sub-text font-heading text-sm">${album.photoCount} photo${album.photoCount !== 1 ? 's' : ''}</p>
                    </div>
                </div>
            `).join('');
        }

        // Open album
        function openAlbum(albumId) {
            currentAlbum = albums.find(a => a.id === albumId);
            if (!currentAlbum) return;

            albumsView.classList.add('hidden');
            photosView.classList.remove('hidden');
            backBtn.classList.remove('hidden');
            pageTitle.textContent = currentAlbum.title;

            renderPhotos();
        }

        // Render photos in album
        function renderPhotos() {
            photosGrid.innerHTML = currentAlbum.photos.map((photo, index) => `
                <div class="relative aspect-[4/3] overflow-hidden rounded-lg cursor-pointer group"
                     onclick="openLightbox(${index})">
                    <img src="${photo}"
                         alt="Photo ${index + 1}"
                         class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300"></div>
                </div>
            `).join('');
        }

        // Back to albums
        backBtn.addEventListener('click', () => {
            albumsView.classList.remove('hidden');
            photosView.classList.add('hidden');
            backBtn.classList.add('hidden');
            pageTitle.textContent = 'Hostel Gallery Albums';
            currentAlbum = null;
        });

        // Lightbox functions
        function openLightbox(index) {
            currentPhotoIndex = index;
            lightboxImg.src = currentAlbum.photos[currentPhotoIndex];
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightboxFunc() {
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showPrevPhoto() {
            currentPhotoIndex = (currentPhotoIndex - 1 + currentAlbum.photos.length) % currentAlbum.photos.length;
            lightboxImg.src = currentAlbum.photos[currentPhotoIndex];
        }

        function showNextPhoto() {
            currentPhotoIndex = (currentPhotoIndex + 1) % currentAlbum.photos.length;
            lightboxImg.src = currentAlbum.photos[currentPhotoIndex];
        }

        // Event listeners
        closeLightbox.addEventListener('click', closeLightboxFunc);
        prevPhoto.addEventListener('click', showPrevPhoto);
        nextPhoto.addEventListener('click', showNextPhoto);

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightboxFunc();
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightboxFunc();
                if (e.key === 'ArrowLeft') showPrevPhoto();
                if (e.key === 'ArrowRight') showNextPhoto();
            }
        });

        // Initialize
        renderAlbums();
    </script>
@endsection
