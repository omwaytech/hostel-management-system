 <style>
     /* Custom animations and transitions */
     .sidebar-enter {
         transform: translateX(100%);
         transition: transform 0.4s ease-in-out;
     }

     .sidebar-open {
         transform: translateX(0);
     }

     .close-btn-enter {
         transform: translateX(100%);
         transition: transform 0.4s ease-in-out 0.2s;
     }

     .close-btn-open {
         transform: translateX(0);
     }

     .menu-link {
         transform: translateX(80%);
         transition: transform 0.4s ease-in-out;
         position: relative;
     }

     .menu-link-open {
         transform: translateX(0);
     }

     .menu-link:nth-child(1) {
         transition-delay: 0.05s;
     }

     .menu-link:nth-child(2) {
         transition-delay: 0.1s;
     }

     .menu-link:nth-child(3) {
         transition-delay: 0.15s;
     }

     .menu-link:nth-child(4) {
         transition-delay: 0.2s;
     }

     .menu-link:nth-child(5) {
         transition-delay: 0.25s;
     }

     .menu-link::before {
         content: "";
         height: 2px;
         background: #023BE4;
         width: 70px;
         position: absolute;
         bottom: -2px;
         left: 0;
         transform: translateX(-50%);
         opacity: 0;
         transition: transform 0.4s ease-in-out, opacity 0.4s linear;
     }

     .menu-link:hover::before {
         transform: translateX(0);
         opacity: 1;
     }
 </style>

 <!-- Navigation Bar -->
 <nav class="bg-white h-[88px] flex items-center justify-between px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20 sticky top-0 ">
     <!-- Logo Section -->
     <div class="flex items-center">
         <a href="{{ route('home') }}">
             @if (isset($systemConfigs['navbar_logo']) && $systemConfigs['navbar_logo'])
             <img src="{{ asset('storage/images/adminConfigImages/' . $systemConfigs['navbar_logo']) }}"
                 alt="OmWay Technologies" class="h-12 sm:h-14 md:h-12 w-auto">
             @else
             <img src="{{ asset('assets/images/default-logo.png') }}" alt="OmWay Technologies"
                 class="h-12 sm:h-14 md:h-12 w-auto">
             @endif
         </a>
     </div>

     <!-- Right Side: CTA Button + Hamburger -->
     <div class="flex items-center gap-4">
         <a href="{{ route('home') }}#hostelListing"
             class="flex items-center justify-center font-heading text-sm rounded-[50px] w-full px-6 py-2.5 text-center text-white duration-200 bg-[#2B6CB0] border-2 border-[#2B6CB0] nline-flex hover:bg-transparent hover:border-[#2B6CB0] hover:text-[#2B6CB0] focus:outline-none focus-visible:outline-[#2B6CB0]  focus-visible:ring-[#2B6CB0]">
             List Your Hostel
         </a>
         <!-- Hamburger Button -->
         <label for="menu-control" class="flex h-[18px] w-6 flex-col justify-between cursor-pointer select-none z-10">
             <i class="inline-block h-0.5 w-6 bg-gray-800 rounded-xs"></i>
             <i class="inline-block h-0.5 w-6 bg-gray-800 rounded-xs"></i>
             <i class="inline-block h-0.5 w-6 bg-gray-800 rounded-xs"></i>
         </label>
     </div>
 </nav>

 <!-- Hidden Checkbox -->
 <input type="checkbox" id="menu-control" class="hidden peer">

 <!-- Overlay -->
 <div id="overlay" class="fixed inset-0 bg-black/50 opacity-0 invisible transition-all duration-300 z-55"></div>

 <!-- Sidebar (Right Side) -->
 <aside id="sidebar"
     class="sidebar-enter fixed h-screen w-[310px] bg-white top-0 right-0 px-[45px] py-0 flex flex-col shadow-2xl z-60">

     <!-- Close Button -->
     <label for="menu-control" id="close-btn"
         class="close-btn-enter absolute top-1/2 left-[-30px] -translate-y-1/2 bg-white h-[50px] w-[50px] rounded-full shadow-[0_0_20px_20px_rgba(0,0,0,0.03)] flex justify-center items-center cursor-pointer">
         <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#1f1f1f" stroke-width="2.5" stroke-linecap="round"
             stroke-linejoin="round">
             <line x1="5" y1="5" x2="19" y2="19"></line>
             <line x1="19" y1="5" x2="5" y2="19"></line>
         </svg>
     </label>

     <!-- Menu Links -->
     <nav class="flex flex-col flex-1 font-heading justify-around text-xl mt-20 mb-24 text-color">
         <a href="{{ route('home') }}" class="menu-link text-current no-underline">Home</a>
         <a href="{{ route('about') }}" class="menu-link text-current no-underline">About</a>
         <a href="{{ route('hostel') }}" class="menu-link text-current no-underline">Hostel</a>
         <a href="{{ route('blog') }}" class="menu-link text-current no-underline">News & Blogs</a>
         <a href="{{ route('faq') }}" class="menu-link text-current no-underline">FAQ's</a>
     </nav>

     <!-- User account -->
     @auth
     @if (auth()->user()->resident)
     <div class="mb-8">
         <a href="{{ route('resident.dashboard') }}"
             class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
             <div
                 class="w-12 h-12 rounded-full bg-[#023BE4] flex items-center justify-center text-white font-bold text-lg">
                 {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
             </div>
             <div class="flex flex-col">
                 <span class="font-heading font-bold text-color text-sm">{{ auth()->user()->name }}</span>
                 <span class="text-xs text-gray-500">View Dashboard</span>
             </div>
         </a>
     </div>
     @else
     <ul class="flex list-none text-sm p-0 mb-8 gap-3">
         {{-- <li>
                     <button id="createAccountBtn"
                         class="text-color button-color font-heading text-sm rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors h-[45px] self-center font-bold text-color border border-color hover:border-0 px-4 py-2.5">
                         Create Account
                     </button>
                 </li> --}}
         <li>
             <button id="loginBtn"
                 class="bg-[#023be4] font-heading text-base rounded-[50px] text-white hover:bg-[#4e81f2] hover:text-white transition-colors h-[50px] self-center font-bold text-color px-10 py-3">
                 Login
             </button>
         </li>
     </ul>
     @endif
     @else
     <ul class="flex list-none text-sm p-0 mb-8 gap-3">
         {{-- <li>
                 <button id="createAccountBtn"
                     class="text-color button-color font-heading text-sm rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors h-[45px] self-center font-bold text-color border border-color hover:border-0 px-4 py-2.5">
                     Create Account
                 </button>
             </li> --}}
         <li>
             <button id="loginBtn"
                 class="bg-[#023be4] font-heading text-base rounded-[50px] text-white hover:bg-[#4e81f2] hover:text-white transition-colors h-[50px] self-center font-bold text-color px-10 py-3">
                 Login
             </button>
         </li>
     </ul>
     @endauth
 </aside>

 <!-- Auth Modal -->
 <div id="authModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-70">
     <div class="bg-white rounded-lg p-8 max-w-xl w-full mx-4 relative">
         <!-- Close button -->
         <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
             </svg>
         </button>

         <!-- Register Form -->
         <div id="registerForm" class="space-y-4">
             <h2 class="text-xl font-heading font-bold mb-6 text-color">Register and find your Hostel hub</h2>
             <form id="createAccountForm" class="space-y-4">
                 <div class="grid grid-cols-2 gap-4">
                     <div>
                         <input type="text" id="firstName" name="firstName" placeholder="First Name" required
                             class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                     </div>
                     <div>
                         <input type="text" id="lastName" name="lastName" placeholder="Last Name" required
                             class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                     </div>
                 </div>
                 <div class="grid grid-cols-2 gap-4">
                     <div>
                         <input type="tel" id="phone" name="phone" placeholder="Phone" required
                             class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                     </div>
                     <div>
                         <input type="email" id="email" name="email" placeholder="Email" required
                             class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                     </div>
                 </div>
                 <div class="flex items-start">
                     <input type="checkbox" id="consent" name="consent" required class="mt-1 h-4 w-4 text-blue-600">
                     <label for="consent" class="ml-2 block text-sm text-gray-600">
                         By continuing, you agree to allow Hostel Hub to use your provided information to process
                         property inquiries, manage bookings or listings, and communicate with you in the future. You
                         can
                         review our complete policy for more details. <a href="#"
                             class="text-blue-600 hover:underline">Privacy Policy</a>.
                     </label>
                 </div>
                 <button type="submit"
                     class="w-full text-color button-color font-heading text-sm rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors h-[45px] self-center font-bold text-color border border-color hover:border-0 px-4 py-2.5">
                     Continue
                 </button>

                 <div class="relative text-center my-4">
                     <div class="absolute inset-0 flex items-center">
                         <div class="w-full border-t border-color"></div>
                     </div>
                     <span class="relative bg-white px-4 text-sm text-gray-500">Or</span>
                 </div>

                 <button type="button"
                     class="w-full flex items-center justify-center gap-2 border border-color rounded-full py-3 px-4 hover:bg-gray-50 transition-colors">
                     <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo" class="h-5 w-5">
                     <span>Sign in with Google</span>
                 </button>

                 <div class="text-center text-sm font-heading font-light sub-text mt-4">
                     Already have an account? <a href="#" class="text-blue-600 font-heading hover:underline"
                         id="switchToLogin">Login</a>
                 </div>
             </form>
         </div>

         <!-- Login Form -->
         <div id="loginForm" class="space-y-4 hidden">
             <h2 class="text-xl font-heading font-bold mb-6 text-color">Welcome back to Hostel hub</h2>
             <form id="loginAccountForm" class="space-y-4">
                 <div>
                     <input type="email" id="loginEmail" name="email" placeholder="Email" required
                         class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                 </div>
                 <div>
                     <input type="password" id="loginPassword" name="password" placeholder="Password" required
                         class="w-full text-sm font-light font-heading text-color px-4 py-3 border border-color rounded-sm focus:outline-none focus:ring-1 focus:ring-[#01217f]/60 focus:border-transparent outline-none">
                 </div>
                 <div class="flex justify-end">
                     <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                 </div>
                 <button type="submit"
                     class="w-full text-color button-color font-heading text-sm rounded-[50px] hover:bg-[#023BE4] hover:text-white transition-colors h-[45px] self-center font-bold text-color border border-color hover:border-0 px-4 py-2.5">
                     Login
                 </button>

                 <div class="relative text-center my-4">
                     <div class="absolute inset-0 flex items-center">
                         <div class="w-full border-t border-color"></div>
                     </div>
                     <span class="relative bg-white px-4 text-sm text-gray-500">Or</span>
                 </div>

                 <button type="button"
                     class="w-full flex items-center justify-center gap-2 border border-color rounded-full py-3 px-4 hover:bg-gray-50 transition-colors">
                     <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo" class="h-5 w-5">
                     <span>Sign in with Google</span>
                 </button>

                 {{-- <div class="text-center text-sm font-heading font-light sub-text mt-4">
                     Don't have an account? <a href="#" class="text-blue-600 font-heading hover:underline"
                         id="switchToRegister">Create Account</a>
                 </div> --}}
             </form>
         </div>
     </div>
 </div>

 <script>
     const menuControl = document.getElementById('menu-control');
     const sidebar = document.getElementById('sidebar');
     const closeBtn = document.getElementById('close-btn');
     const menuLinks = document.querySelectorAll('.menu-link');
     const overlay = document.getElementById('overlay');

     // Modal elements
     const createAccountBtn = document.getElementById('createAccountBtn');
     const loginBtn = document.getElementById('loginBtn');
     const authModal = document.getElementById('authModal');
     const closeModalBtn = document.getElementById('closeModalBtn');
     const createAccountForm = document.getElementById('createAccountForm');
     const loginForm = document.getElementById('loginForm');
     const registerForm = document.getElementById('registerForm');
     const switchToLogin = document.getElementById('switchToLogin');
     const switchToRegister = document.getElementById('switchToRegister');
     const loginAccountForm = document.getElementById('loginAccountForm');

     menuControl.addEventListener('change', function() {
         if (this.checked) {
             sidebar.classList.add('sidebar-open');
             closeBtn.classList.add('close-btn-open');
             overlay.classList.remove('opacity-0', 'invisible');
             overlay.classList.add('opacity-100', 'visible');
             menuLinks.forEach(link => {
                 link.classList.add('menu-link-open');
             });
         } else {
             sidebar.classList.remove('sidebar-open');
             closeBtn.classList.remove('close-btn-open');
             overlay.classList.remove('opacity-100', 'visible');
             overlay.classList.add('opacity-0', 'invisible');
             menuLinks.forEach(link => {
                 link.classList.remove('menu-link-open');
             });
         }
     });

     // Close sidebar when clicking on overlay
     overlay.addEventListener('click', function() {
         menuControl.checked = false;
         menuControl.dispatchEvent(new Event('change'));
     });

     // Modal functionality
     function showModal(showRegister = true) {
         // Save current URL for redirect after login
         sessionStorage.setItem('redirectAfterLogin', window.location.href);

         authModal.classList.remove('hidden');
         authModal.classList.add('flex');
         registerForm.classList.toggle('hidden', !showRegister);
         loginForm.classList.toggle('hidden', showRegister);
         menuControl.checked = false;
         menuControl.dispatchEvent(new Event('change'));
     }

     // Check if buttons exist before adding event listeners (they won't exist when user is logged in)
     if (createAccountBtn) {
         createAccountBtn.addEventListener('click', () => showModal(true));
     }
     if (loginBtn) {
         loginBtn.addEventListener('click', () => showModal(false));
     }

     closeModalBtn.addEventListener('click', function() {
         authModal.classList.add('hidden');
         authModal.classList.remove('flex');
     });

     // Close modal when clicking outside
     authModal.addEventListener('click', function(e) {
         if (e.target === authModal) {
             authModal.classList.add('hidden');
             authModal.classList.remove('flex');
         }
     });

     // Switch between login and register forms
     if (switchToLogin) {
         switchToLogin.addEventListener('click', function(e) {
             e.preventDefault();
             registerForm.classList.add('hidden');
             loginForm.classList.remove('hidden');
         });
     }

     if (switchToRegister) {
         switchToRegister.addEventListener('click', function(e) {
             e.preventDefault();
             registerForm.classList.remove('hidden');
             loginForm.classList.add('hidden');
         });
     }

     // Handle registration form submission
     if (createAccountForm) {
         createAccountForm.addEventListener('submit', function(e) {
             e.preventDefault();
             const formData = new FormData(createAccountForm);

             // Validate phone number
             const phone = formData.get('phone');
             if (!/^\d{10}$/.test(phone)) {
                 alert('Please enter a valid 10-digit phone number');
                 return;
             }

             // Validate email
             const email = formData.get('email');
             if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                 alert('Please enter a valid email address');
                 return;
             }

             // You can make an AJAX request to your Laravel backend here
             fetch('/register', {
                     method: 'POST',
                     body: formData,
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                         'Accept': 'application/json'
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         // Get the saved redirect URL or use dashboard as default
                         const redirectUrl = sessionStorage.getItem('redirectAfterLogin') || data.redirect ||
                             '/dashboard';

                         // Clear the saved URL
                         sessionStorage.removeItem('redirectAfterLogin');

                         // Redirect to the saved page or dashboard
                         window.location.href = redirectUrl;
                     } else {
                         alert(data.message || 'Registration failed. Please try again.');
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     alert('An error occurred. Please try again.');
                 });
         });
     }

     // Handle login form submission
     if (loginAccountForm) {
         loginAccountForm.addEventListener('submit', function(e) {
             e.preventDefault();
             const formData = new FormData(loginAccountForm);

             // Validate email
             const email = formData.get('email');
             if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                 alert('Please enter a valid email address');
                 return;
             }

             // Send login request to resident portal
             fetch("{{ route('resident.login') }}", {
                     method: 'POST',
                     body: formData,
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                         'Accept': 'application/json'
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         // Get the saved redirect URL or use dashboard as default
                         const redirectUrl = sessionStorage.getItem('redirectAfterLogin') || data.redirect ||
                             "{{ route('resident.dashboard') }}";

                         // Clear the saved URL
                         sessionStorage.removeItem('redirectAfterLogin');

                         // Redirect to the saved page or dashboard
                         window.location.href = redirectUrl;
                     } else {
                         // Reload page to show toastr error message
                         if (data.showToastr) {
                             window.location.reload();
                         } else {
                             alert(data.message ||
                                 'Login failed. Please check your credentials and try again.');
                         }
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     alert('An error occurred. Please try again.');
                 });
         });
     }
 </script>