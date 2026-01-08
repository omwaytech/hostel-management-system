  <div
      class="min-h-screen bg-gradient-to-br from-[#00A1A5] via-[#076166] to-[#076166] flex items-center justify-center p-4">
      <div class="w-full max-w-md bg-white rounded-[8px] shadow-custom-combo p-8">
          <div class="text-center mb-8">
              <h1 class="text-3xl font-bold text-color mb-2">Welcome Back</h1>
              <p class="text-gray-600 font-regular font-heading">Sign in to your account</p>
          </div>

          <form id="hostelSigninForm" class="space-y-5">
              @csrf
              <div>
                  <label class="block text-sm font-regular font-heading mb-3">
                      Email Address
                  </label>
                  <input type="email" name="email" id="email" required
                      class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                      placeholder="john@example.com">
              </div>

              <div>
                  <label class="block text-sm font-regular font-heading mb-3">
                      Password
                  </label>
                  <input type="password" name="password" id="password" required
                      class="w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none"
                      placeholder="••••••••">
              </div>

              <div class="flex items-center justify-between">
                  <div class="flex items-center">
                      <input type="checkbox" name="rememberMe" id="rememberMe"
                          class="h-4 w-4  focus:ring-0 focus:ring-[#646E82]/60 focus:border-transparent outline-none border-gray-300 rounded">
                      <label for="rememberMe" class="ml-2 text-sm text-gray-700">
                          Remember me
                      </label>
                  </div>
                  <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                      Forgot password?
                  </a>
              </div>

              <button type="submit" id="signinBtn"
                  class="w-full bg-[#00A1A5] hover:bg-[#076166] text-white font-semibold py-3 rounded-lg  transform  transition duration-200">
                  Sign In
              </button>
          </form>

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
                  Don't have an account?
                  <a href="{{ route('hostel.register', $hostel->slug) }}"
                      class="text-indigo-600 hover:text-indigo-700 font-semibold">
                      Create account
                  </a>
              </p>
          </div>
      </div>
  </div>


  <!-- Toastr CSS -->
  <link rel="stylesheet" href="{{ asset('assets/dist-assets/css/toastr.min.css') }}">

  <style>
      body {
          visibility: hidden;
      }
  </style>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- jQuery (required for toastr) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Toastr JS -->
  <script src="{{ asset('assets/dist-assets/js/toastr.min.js') }}"></script>

  <script>
      // Show content after Tailwind loads
      document.addEventListener('DOMContentLoaded', () => {
          document.body.style.visibility = 'visible';

          // Handle signin form submission
          const signinForm = document.getElementById('hostelSigninForm');
          const signinBtn = document.getElementById('signinBtn');

          signinForm.addEventListener('submit', function(e) {
              e.preventDefault();

              // Disable button and show loading state
              signinBtn.disabled = true;
              signinBtn.textContent = 'Signing in...';

              const formData = new FormData(signinForm);

              fetch('{{ route('hostel.signin.login', $hostel->slug) }}', {
                      method: 'POST',
                      body: formData,
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                          'Accept': 'application/json'
                      }
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          // Redirect to dashboard - toastr will show on next page
                          window.location.href = data.redirect;
                      } else {
                          // Reload page to show toastr error message
                          if (data.showToastr) {
                              window.location.reload();
                          } else {
                              alert(data.message || 'Login failed. Please check your credentials.');
                              signinBtn.disabled = false;
                              signinBtn.textContent = 'Sign In';
                          }
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      alert('An error occurred. Please try again.');
                      signinBtn.disabled = false;
                      signinBtn.textContent = 'Sign In';
                  });
          });

          // Display toastr notifications if present
          @if (Session::has('message'))
              var type = "{{ Session::get('alert-type') }}";
              var message = "{{ Session::get('message') }}";

              toastr.options = {
                  "closeButton": true,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "timeOut": "5000"
              };

              switch (type) {
                  case 'info':
                      toastr.info(message);
                      break;
                  case 'success':
                      toastr.success(message);
                      break;
                  case 'warning':
                      toastr.warning(message);
                      break;
                  case 'error':
                      toastr.error(message);
                      break;
              }
          @endif
      });
  </script>
