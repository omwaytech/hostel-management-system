 <div
     class="min-h-screen bg-gradient-to-br from-[#00A1A5] via-[#076166] to-[#076166] flex items-center justify-center p-4">
     <div class="w-full max-w-xl bg-white rounded-2xl shadow-2xl p-8">
         <div class="text-center mb-8">
             <h1 class="text-3xl font-bold text-gray-800 mb-2">Create an Account</h1>
             <p class="text-gray-600">Join us today and get started</p>
         </div>

         <div class="space-y-5">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="block text-sm font-regular font-heading mb-3">
                         First Name
                     </label>
                     <input type="text" name="Name"
                         class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                         placeholder="John">
                 </div>
                 <div>
                     <label class="block text-sm font-regular font-heading mb-3">
                         Email Address
                     </label>
                     <input type="email" name="email"
                         class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                         placeholder="john@example.com">
                 </div>
                 <div>
                     <label class="block text-sm font-regular font-heading mb-3">
                         Password
                     </label>
                     <input type="password" name="password"
                         class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                         placeholder="••••••••">
                 </div>
                 <div>
                     <label class="block text-sm font-regular font-heading mb-3">
                         Confirm Password
                     </label>
                     <input type="password" name="password"
                         class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                         placeholder="••••••••">
                 </div>
             </div>
             <div class="flex items-start">
                 <input type="checkbox" name="agreedToTerms"
                     class="mt-1 h-4 w-4 focus:ring-0 focus:ring-[#646E82]/60 focus:border-transparent outline-none border-gray-300 rounded">
                 <label class="ml-3 text-sm text-gray-700">
                     I agree to the
                     <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">
                         Terms and Conditions
                     </a>
                 </label>
             </div>

             <button
                 class="w-full bg-[#00A1A5] hover:bg-[#076166] text-white font-semibold py-3 rounded-lg  transform transition duration-200">
                 Create Account
             </button>
         </div>

         <div class="mt-6">
             <div class="relative">
                 <div class="absolute inset-0 flex items-center">
                     <div class="w-full border-t border-gray-300"></div>
                 </div>
                 <div class="relative flex justify-center text-sm">
                     <span class="px-4 bg-white text-gray-500">or</span>
                 </div>
             </div>

             <button
                 class="mt-6 w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition duration-200">
                 <svg class="w-5 h-5" viewBox="0 0 24 24">
                     <path fill="#4285F4"
                         d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z">
                     </path>
                     <path fill="#34A853"
                         d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z">
                     </path>
                     <path fill="#FBBC05"
                         d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z">
                     </path>
                     <path fill="#EA4335"
                         d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z">
                     </path>
                 </svg>
                 Continue with Google
             </button>
         </div>

         <div class="mt-6 text-center">
             <p class="text-sm text-gray-600">
                 Already have an account?
                 <a href="{{ route('hostel.signin', [$hostel->slug]) }}"
                     class="text-purple-600 hover:text-purple-700 font-semibold">
                     Sign in
                 </a>
             </p>
         </div>
     </div>
 </div>

 <style>
     body {
         visibility: hidden;
     }
 </style>
 <script src="https://cdn.tailwindcss.com"></script>
 <script>
     // Show content after Tailwind loads
     document.addEventListener('DOMContentLoaded', () => {
         document.body.style.visibility = 'visible';
     });
 </script>
