@extends('frontend.layouts.hostelPortal')

@section('body')
    <div class="container bg-white border border-[#E2E7E9] mx-auto px-4 md:px-8 lg:px-[120px] max-w-full">
        <!-- Back Button and Room Header -->
        <div class="mb-6 mt-6 text-sm">
            <a href="{{ route('hostel.room', $hostel->slug) }}"
                class="inline-flex  items-center border rounded-[4px] gap-1 border-[#E1DFDF] px-4 py-2 hover-bg-color hover:text-white hover-text-color mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        d="M7.499 6.497L3.5 10.499l4 4.001m9-4h-13" stroke-width="1" />
                </svg>
                Back to Room Listing
            </a>
            <div class="flex items-start space-x-2 mt-2">
                @if ($room->photo)
                    <img src="{{ asset('storage/images/roomPhotos/' . $room->photo) }}" alt="Room {{ $room->room_number }}"
                        class="w-20 h-20 rounded-lg object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=200"
                        alt="Room {{ $room->room_number }}" class="w-20 h-20 rounded-lg object-cover">
                @endif
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-color">
                        @if ($room->occupancy)
                            {{ $room->occupancy->occupancy_type }} Shared Room - Room {{ $room->room_number }}
                        @else
                            Room {{ $room->room_number }}
                        @endif
                    </h1>
                    <div class="flex items-center space-x-2 text-[#6A767C] font-heading text-sm font-regular">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span>
                                @if ($room->occupancy)
                                    {{ $room->occupancy->occupancy_type }} • {{ $room->beds->count() }} persons
                                @else
                                    {{ $room->beds->count() }} beds
                                @endif
                            </span>
                        </div>
                        @if ($room->floor && $room->floor->block)
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $room->floor->block->name }}, {{ $room->floor->block->location }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Container -->
    <div class="max-w-[1920px] mx-auto px-4 md:px-8 lg:px-[120px] py-10">
        <form action="{{ route('hostel.checkout.store', $hostel->slug) }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="monthly_rent" id="monthly_rent"
                value="{{ $room->occupancy ? $room->occupancy->monthly_rent : 0 }}">
            <input type="hidden" name="security_deposit" id="security_deposit" value="0">
            <input type="hidden" name="total_amount" id="total_amount" value="0">

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- LEFT SIDE -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Personal Info -->
                    <div class="bg-white p-6 rounded-[8px] shadow-custom-combo">
                        <div class="flex items-center gap-2">
                            <!-- Document SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                    <path
                                        d="m12.88 7.017l4.774 1.271m-5.796 2.525l2.386.636m-2.267 6.517l.954.255c2.7.72 4.05 1.079 5.114.468c1.063-.61 1.425-1.953 2.148-4.637l1.023-3.797c.724-2.685 1.085-4.027.471-5.085s-1.963-1.417-4.664-2.136l-.954-.255c-2.7-.72-4.05-1.079-5.113-.468c-1.064.61-1.426 1.953-2.15 4.637l-1.022 3.797c-.724 2.685-1.086 4.027-.471 5.085c.614 1.057 1.964 1.417 4.664 2.136Z" />
                                    <path
                                        d="m12 20.946l-.952.26c-2.694.733-4.04 1.1-5.102.477c-1.06-.622-1.422-1.991-2.143-4.728l-1.021-3.872c-.722-2.737-1.083-4.106-.47-5.184C2.842 6.966 4 7 5.5 7" />
                                </g>
                            </svg>

                            <!-- Text -->
                            <h1 class="text-lg text-color font-heading font-semibold">Personal Information</h1>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4 mt-3">
                            <div>
                                <label class="text-sm font-regular font-heading text-color">Full Name *</label>
                                <input type="text" name="full_name" placeholder="Enter your full name"
                                    value="{{ old('full_name') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('full_name') border-red-500 @enderror" />
                                @error('full_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading text-color">Email Address *</label>
                                <input type="email" name="email" placeholder="youremail@example.com"
                                    value="{{ old('email') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('email') border-red-500 @enderror" />
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading text-color">Phone Number *</label>
                                <input type="tel" name="phone" placeholder="+977 98XXXXXXXX"
                                    value="{{ old('phone') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('phone') border-red-500 @enderror" />
                                @error('phone')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading text-color">Current Address *</label>
                                <input type="text" name="current_address" placeholder="Enter your current address"
                                    value="{{ old('current_address') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('current_address') border-red-500 @enderror" />
                                @error('current_address')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="bg-white p-6 rounded-[8px] shadow-custom-combo">
                        <div class="flex items-center gap-2">
                            <!-- Document SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M4 8c0-2.828 0-4.243.879-5.121C5.757 2 7.172 2 10 2h4c2.828 0 4.243 0 5.121.879C20 3.757 20 5.172 20 8v8c0 2.828 0 4.243-.879 5.121C18.243 22 16.828 22 14 22h-4c-2.828 0-4.243 0-5.121-.879C4 20.243 4 18.828 4 16z" />
                                    <path d="M19.898 16h-12c-.93 0-1.395 0-1.777.102A3 3 0 0 0 4 18.224" opacity="0.5" />
                                    <path stroke-linecap="round" d="M8 7h8m-8 3.5h5" opacity="0.5" />
                                </g>
                            </svg>

                            <!-- Text -->
                            <h1 class="text-lg text-color font-heading font-semibold">Booking Details</h1>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4 mt-3">
                            <div>
                                <label class="text-sm font-regular font-heading">Move-in Date *</label>
                                <input type="date" name="move_in_date" min="{{ date('Y-m-d') }}"
                                    value="{{ old('move_in_date') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('move_in_date') border-red-500 @enderror" />
                                @error('move_in_date')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading">Duration (months) *</label>
                                <input type="number" name="duration" id="duration" min="1"
                                    value="{{ old('duration', 1) }}" placeholder="Enter duration in months"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('duration') border-red-500 @enderror" />
                                @error('duration')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading">Number of Occupants *</label>
                                <input type="number" name="occupant_count" min="1"
                                    max="{{ $room->occupancy ? $room->occupancy->capacity : 1 }}"
                                    value="{{ old('occupant_count', 1) }}" placeholder="Number of occupants"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('occupant_count') border-red-500 @enderror" />
                                @error('occupant_count')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading">Emergency Contact *</label>
                                <input type="text" name="emergency_contact" placeholder="Enter emergency contact"
                                    value="{{ old('emergency_contact') }}"
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none @error('emergency_contact') border-red-500 @enderror" />
                                @error('emergency_contact')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    <div class="bg-white p-6 rounded-[8px] shadow-custom-combo">
                        <div class="flex items-center gap-2">
                            <!-- Document SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="m18.18 8.04l.463-.464a1.966 1.966 0 1 1 2.781 2.78l-.463.464M18.18 8.04s.058.984.927 1.853s1.854.927 1.854.927M18.18 8.04l-4.26 4.26c-.29.288-.434.433-.558.592q-.22.282-.374.606c-.087.182-.151.375-.28.762l-.413 1.24l-.134.401m8.8-5.081l-4.26 4.26c-.29.29-.434.434-.593.558q-.282.22-.606.374c-.182.087-.375.151-.762.28l-1.24.413l-.401.134m0 0l-.401.134a.53.53 0 0 1-.67-.67l.133-.402m.938.938l-.938-.938" />
                                    <path stroke-linecap="round"
                                        d="M8 13h2.5M8 9h6.5M8 17h1.5M19.828 3.172C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172S3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828S7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172c.944-.943 1.127-2.348 1.163-4.828" />
                                </g>
                            </svg>

                            <!-- Text -->
                            <h1 class="text-lg text-color font-heading font-semibold">Special request</h1>
                        </div>
                        <div class="space-y-4 mt-3">
                            <div>
                                <label class="text-sm font-regular font-heading">Dietary / Other Preferences</label>
                                <textarea name="dietary_preferences" rows="2" placeholder="Any dietary restrictions or preferences..."
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none">{{ old('dietary_preferences') }}</textarea>
                            </div>
                            <div>
                                <label class="text-sm font-regular font-heading">Additional Requests</label>
                                <textarea name="additional_requests" rows="2" placeholder="Any special requests or requirements..."
                                    class="mt-1 w-full border border-[#E1DFDF] rounded-[4px] px-3 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-[#646E82]/60 focus:border-transparent outline-none">{{ old('additional_requests') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Options -->
                    {{-- <div class="bg-white p-6 rounded-[8px] shadow-custom-combo">
                        <div class="flex items-center gap-2">
                            <!-- Document SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
                                <path fill="currentColor"
                                    d="M13.5 13a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zM2 6.75A2.75 2.75 0 0 1 4.75 4h10.5A2.75 2.75 0 0 1 18 6.75v6.5A2.75 2.75 0 0 1 15.25 16H4.75A2.75 2.75 0 0 1 2 13.25zM4.75 5A1.75 1.75 0 0 0 3 6.75V8h14V6.75A1.75 1.75 0 0 0 15.25 5zM17 9H3v4.25c0 .966.784 1.75 1.75 1.75h10.5A1.75 1.75 0 0 0 17 13.25z" />
                            </svg>

                            <!-- Text -->
                            <h1 class="text-lg text-color font-heading font-semibold">Payment Options</h1>
                        </div>
                        <div class="space-y-3 mt-3">
                            <label class="flex items-center gap-2 font-heading font-regular text-sm text-color">
                                <input type="radio" name="payment_method" value="cash_on_arrival"
                                    class="text-teal-500"
                                    {{ old('payment_method') == 'cash_on_arrival' ? 'checked' : '' }} />
                                <span>Cash on Arrival</span>
                            </label>
                            <label class="flex items-center gap-2 font-heading font-regular text-sm text-color">
                                <input type="radio" name="payment_method" value="full_payment" class="text-teal-500"
                                    {{ old('payment_method') == 'full_payment' ? 'checked' : '' }} />
                                <span>Make full payment</span>
                            </label>
                            @error('payment_method')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}
                    <input type="hidden" name="payment_method" id="payment_method" value="cash_on_arrival">
                    <!-- Terms -->
                    <div class="bg-white p-6 rounded-[8px] shadow-custom-combo">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 font-heading font-regular text-sm text-color">
                                <input type="checkbox" name="terms_accepted" value="1" class="text-teal-500"
                                    {{ old('terms_accepted') ? 'checked' : '' }} />
                                <span class="text-sm">
                                    I agree to the
                                    <a href="#" class="text-teal-600 underline">
                                        Terms &amp; Conditions
                                    </a>.
                                </span>
                            </label>
                            @error('terms_accepted')
                                <span class="text-red-500 text-xs block">{{ $message }}</span>
                            @enderror
                            <label class="flex items-center gap-2 font-heading font-regular text-sm text-color">
                                <input type="checkbox" name="privacy_accepted" value="1" class="text-teal-500"
                                    {{ old('privacy_accepted') ? 'checked' : '' }} />
                                <span class="text-sm">I agree to the <a href="#"
                                        class="text-teal-600 underline">Privacy
                                        Policy</a>.</span>
                            </label>
                            @error('privacy_accepted')
                                <span class="text-red-500 text-xs block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE STICKY CARD -->
                <div class="lg:col-span-1">
                    <div class="lg:sticky top-32 bg-white rounded-[8px] border border-[#E1DFDF] p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            <!-- Document SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z" />
                                    <path stroke-linecap="round" d="M10 16H6m8 0h-1.5M2 10h20" />
                                </g>
                            </svg>

                            <!-- Text -->
                            <h1 class="text-xl text-color font-heading font-semibold">Booking Summary</h1>
                        </div>
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-regular text-lg font-heading">
                                    @if ($room->occupancy)
                                        {{ $room->occupancy->occupancy_type }} Shared Room - Room {{ $room->room_number }}
                                    @else
                                        Room {{ $room->room_number }}
                                    @endif
                                </h3>
                                {{-- <p class="text-sm sub-text font-heading font-light">
                                @if ($room->occupancy)
                                    {{ $room->beds->count() }} persons
                                @else
                                    {{ $room->beds->count() }} bed{{ $room->beds->count() != 1 ? 's' : '' }}
                                @endif
                            </p> --}}
                            </div>
                            @php
                                $availableBeds = $room->beds->where('status', 'Available')->count();
                            @endphp
                            @if ($availableBeds > 0)
                                <span
                                    class="inline-block bg-[#21C45D] text-white text-xs font-medium px-3 py-1 rounded-full">
                                    Available
                                </span>
                            @else
                                <span
                                    class="inline-block bg-red-500 text-white text-xs font-medium px-3 py-1 rounded-full">
                                    Occupied
                                </span>
                            @endif
                        </div>

                        <div class="border-t  pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="sub-text text-sm font-heading font-regular">
                                    Monthly Rent:
                                </span>
                                <span class="text-color text-sm font-medium font-heading" id="display_monthly_rent">
                                    NPR
                                    {{ $room->occupancy ? number_format($room->occupancy->monthly_rent) : '0' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="sub-text text-sm font-heading font-regular">
                                    Duration:
                                </span>
                                <span class="text-color text-sm font-medium font-heading" id="display_duration">
                                    1 month
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="sub-text text-sm font-heading font-regular">
                                    Subtotal:
                                </span>
                                <span class="text-color text-sm font-medium font-heading" id="display_subtotal">NPR
                                    {{ $room->occupancy ? number_format($room->occupancy->monthly_rent) : '0' }}
                                </span>
                            </div>
                            <div class="flex justify-between ">
                                <span class="sub-text text-sm font-heading font-regular">
                                    Security Deposit:
                                </span>
                                <span class="text-color text-sm font-medium font-heading" id="display_security_deposit">
                                    NPR 0
                                </span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-lg font-semibold flex justify-between">Total Amount:
                                <span class="text-teal-600 font-semibold fomt-heading text-lg" id="display_total">NPR
                                    {{ $room->occupancy ? number_format($room->occupancy->monthly_rent) : '0' }}
                                </span>
                            </p>
                        </div>

                        <div class="bg-[#EEF6F2] p-4 rounded-[8px] text-sm">
                            <p class="font-medium mb-2 font-heading text-color">What’s Included:</p>
                            @if ($room->room_inclusions && is_array($room->room_inclusions) && count($room->room_inclusions) > 0)
                                <ul class="list-disc list-inside sub-text space-y-1">
                                    @foreach ($room->room_inclusions as $inclusion)
                                        <li>{{ $inclusion }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-disc list-inside sub-text space-y-1">
                                    <li>Basic amenities</li>
                                    <li>Room access</li>
                                </ul>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full bg-[#00A1A5] hover:bg-[#076166] text-white font-bold font-heading text-base py-3 rounded-full transition-colors">
                            Confirm Booking
                        </button>

                        <p class="text-xs text-center text-[#6A767C] font-heading font-light tracking-tight">You won’t be
                            charged yet.
                            Confirmation email
                            after
                            booking.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Hidden Printable Receipt Template -->
    <div id="printableReceipt" style="display: none;">
        <div style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: Arial, sans-serif; background: white;">
            <!-- Header -->
            <div style="text-align: center; border-bottom: 3px solid #00A1A5; padding-bottom: 20px; margin-bottom: 30px;">
                <h1 style="color: #00A1A5; font-size: 32px; margin: 0 0 10px 0; font-weight: bold;">BOOKING CONFIRMATION
                </h1>
                <p style="color: #6A767C; font-size: 14px; margin: 0;">Thank you for choosing our hostel accommodation
                    service</p>
            </div>

            <!-- Booking ID -->
            <div style="background: #EEF6F2; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                <p style="margin: 0; color: #6A767C; font-size: 12px; font-weight: 600; text-transform: uppercase;">Booking
                    Reference</p>
                <p id="print_booking_id" style="margin: 5px 0 0 0; color: #00A1A5; font-size: 24px; font-weight: bold;">
                    #0000</p>
            </div>

            <!-- Guest Information -->
            <div style="margin-bottom: 30px;">
                <h2
                    style="color: #2D3748; font-size: 18px; border-bottom: 2px solid #E1DFDF; padding-bottom: 10px; margin-bottom: 15px;">
                    Guest Information</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px; width: 40%;">Full Name:</td>
                        <td id="print_full_name"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Email:</td>
                        <td id="print_email" style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Phone:</td>
                        <td id="print_phone" style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Accommodation Details -->
            <div style="margin-bottom: 30px;">
                <h2
                    style="color: #2D3748; font-size: 18px; border-bottom: 2px solid #E1DFDF; padding-bottom: 10px; margin-bottom: 15px;">
                    Accommodation Details</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px; width: 40%;">Hostel Name:</td>
                        <td id="print_hostel_name"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Room Number:</td>
                        <td id="print_room_number"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Room Type:</td>
                        <td id="print_room_type"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Block:</td>
                        <td id="print_block_name"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Location:</td>
                        <td id="print_location"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                </table>
            </div>

            <!-- Stay Details -->
            <div style="margin-bottom: 30px;">
                <h2
                    style="color: #2D3748; font-size: 18px; border-bottom: 2px solid #E1DFDF; padding-bottom: 10px; margin-bottom: 15px;">
                    Stay Details</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px; width: 40%;">Move-in Date:</td>
                        <td id="print_move_in_date"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Duration:</td>
                        <td id="print_duration"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Number of Occupants:</td>
                        <td id="print_occupant_count"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600;">-</td>
                    </tr>
                </table>
            </div>

            <!-- Payment Summary -->
            <div style="margin-bottom: 30px;">
                <h2
                    style="color: #2D3748; font-size: 18px; border-bottom: 2px solid #E1DFDF; padding-bottom: 10px; margin-bottom: 15px;">
                    Payment Summary</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px; width: 60%;">Monthly Rent:</td>
                        <td id="print_monthly_rent"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600; text-align: right;">
                            NPR 0.00</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Security Deposit:</td>
                        <td id="print_security_deposit"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600; text-align: right;">
                            NPR 0.00</td>
                    </tr>
                    <tr style="border-top: 2px solid #E1DFDF;">
                        <td style="padding: 15px 0 8px 0; color: #2D3748; font-size: 16px; font-weight: bold;">Total
                            Amount:</td>
                        <td id="print_total_amount"
                            style="padding: 15px 0 8px 0; color: #00A1A5; font-size: 20px; font-weight: bold; text-align: right;">
                            NPR 0.00</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6A767C; font-size: 14px;">Payment Method:</td>
                        <td id="print_payment_method"
                            style="padding: 8px 0; color: #2D3748; font-size: 14px; font-weight: 600; text-align: right;">-
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Important Notice -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 15px; margin-bottom: 30px;">
                <p style="margin: 0; color: #92400E; font-size: 13px; line-height: 1.6;">
                    <strong>Important:</strong> This is a booking confirmation. Shortly, you will be contacted by the Hostel
                    Department to complete the verification process. Please keep this receipt for your records.
                </p>
            </div>

            <!-- Footer -->
            <div style="text-align: center; padding-top: 20px; border-top: 2px solid #E1DFDF;">
                <p id="print_booked_at" style="margin: 0 0 10px 0; color: #6A767C; font-size: 12px;">Booked on: -</p>
                <p style="margin: 0; color: #6A767C; font-size: 11px;">This is a computer-generated document. No signature
                    is required.</p>
            </div>
        </div>
    </div>

    <script>
        // Calculate total amount dynamically
        function calculateTotal() {
            const monthlyRent = parseFloat(document.getElementById('monthly_rent').value) || 0;
            const duration = parseInt(document.getElementById('duration').value) || 1;
            const securityDeposit = parseFloat(document.getElementById('security_deposit').value) || 0;

            const subtotal = monthlyRent * duration;
            const total = subtotal + securityDeposit;

            // Update display values
            document.getElementById('display_monthly_rent').textContent = `NPR ${monthlyRent.toLocaleString('en-NP')}`;
            document.getElementById('display_duration').textContent = `${duration} month${duration !== 1 ? 's' : ''}`;
            document.getElementById('display_subtotal').textContent = `NPR ${subtotal.toLocaleString('en-NP')}`;
            document.getElementById('display_security_deposit').textContent =
                `NPR ${securityDeposit.toLocaleString('en-NP')}`;
            document.getElementById('display_total').textContent = `NPR ${total.toLocaleString('en-NP')}`;

            // Update hidden field
            document.getElementById('total_amount').value = total;
        }

        // Listen for duration changes
        document.getElementById('duration').addEventListener('input', calculateTotal);

        // Calculate on page load
        document.addEventListener('DOMContentLoaded', calculateTotal);

        // Show booking confirmation popup
        @if (session('booking_details'))
            document.addEventListener('DOMContentLoaded', function() {
                const bookingDetails = @json(session('booking_details'));

                // Populate printable receipt
                document.getElementById('print_booking_id').textContent = '#' + bookingDetails.booking_id;
                document.getElementById('print_full_name').textContent = bookingDetails.full_name;
                document.getElementById('print_email').textContent = bookingDetails.email;
                document.getElementById('print_phone').textContent = bookingDetails.phone;
                document.getElementById('print_hostel_name').textContent = bookingDetails.hostel_name;
                document.getElementById('print_room_number').textContent = bookingDetails.room_number;
                document.getElementById('print_room_type').textContent = bookingDetails.room_type;
                document.getElementById('print_block_name').textContent = bookingDetails.block_name;
                document.getElementById('print_location').textContent = bookingDetails.location;
                document.getElementById('print_move_in_date').textContent = bookingDetails.move_in_date;
                document.getElementById('print_duration').textContent = bookingDetails.duration + ' month(s)';
                document.getElementById('print_occupant_count').textContent = bookingDetails.occupant_count +
                    ' person(s)';
                document.getElementById('print_monthly_rent').textContent = 'NPR ' + bookingDetails.monthly_rent;
                document.getElementById('print_security_deposit').textContent = 'NPR ' + bookingDetails
                    .security_deposit;
                document.getElementById('print_total_amount').textContent = 'NPR ' + bookingDetails.total_amount;
                document.getElementById('print_payment_method').textContent = bookingDetails.payment_method;
                document.getElementById('print_booked_at').textContent = 'Booked on: ' + bookingDetails.booked_at;

                // Show SweetAlert popup
                Swal.fire({
                    title: '<strong style="color: #00A1A5;">Booking Confirmed!</strong>',
                    html: `
                        <div style="text-align: left; padding: 20px;">
                            <p style="font-size: 16px; color: #2D3748; margin-bottom: 20px;">
                                You have successfully booked a room at <strong>${bookingDetails.hostel_name}</strong>.
                            </p>

                            <div style="background: #EEF6F2; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <p style="margin: 0 0 8px 0; color: #6A767C; font-size: 12px;">BOOKING ID</p>
                                <p style="margin: 0; color: #00A1A5; font-size: 20px; font-weight: bold;">#${bookingDetails.booking_id}</p>
                            </div>

                            <div style="background: #F9FAFB; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <table style="width: 100%; font-size: 14px;">
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Room:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.room_type} - Room ${bookingDetails.room_number}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Move-in Date:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.move_in_date}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Duration:</td>
                                        <td style="padding: 5px 0; color: #2D3748; font-weight: 600; text-align: right;">${bookingDetails.duration} month(s)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #6A767C;">Total Amount:</td>
                                        <td style="padding: 5px 0; color: #00A1A5; font-weight: bold; font-size: 16px; text-align: right;">NPR ${bookingDetails.total_amount}</td>
                                    </tr>
                                </table>
                            </div>

                            <div style="background: #FEF3C7; padding: 12px; border-radius: 8px; border-left: 4px solid #F59E0B;">
                                <p style="margin: 0; color: #92400E; font-size: 13px; line-height: 1.5;">
                                    <strong>Note:</strong> Shortly, you will be contacted by the Hostel Department to complete the verification process.
                                </p>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    iconColor: '#00A1A5',
                    width: 600,
                    confirmButtonText: '<i class="fa fa-print"></i> Print Receipt',
                    confirmButtonColor: '#00A1A5',
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#6A767C',
                    customClass: {
                        popup: 'booking-popup',
                        confirmButton: 'print-button',
                        cancelButton: 'close-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Print the receipt
                        printReceipt();
                    }
                });
            });

            function printReceipt() {
                const printContent = document.getElementById('printableReceipt').innerHTML;
                const originalContent = document.body.innerHTML;

                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;

                // Reload to restore functionality
                location.reload();
            }
        @endif
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableReceipt,
            #printableReceipt * {
                visibility: visible;
            }

            #printableReceipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
            }
        }

        .booking-popup {
            font-family: 'Inter', sans-serif;
        }

        .print-button,
        .close-button {
            padding: 12px 30px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
        }
    </style>
@endsection
