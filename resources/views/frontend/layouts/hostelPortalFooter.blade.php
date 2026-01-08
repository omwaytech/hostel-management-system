<!-- Footer -->
<footer class="bg-[#1F1F1F] text-slate-200 mt-10">
    <!-- content -->
    <div class="mx-auto w-full max-w-[1920px] px-4 sm:px-6 md:px-[120px] py-14">
        <!-- brand wider, other cols tighter -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-[1.35fr_0.5fr_0.5fr_1fr] lg:gap-x-[50px]">
            <!-- Brand / About -->
            <div>
                <!-- logo + label -->
                <div>
                    <!-- Logo only -->
                    <div class="flex items-center lg:items-start gap-4">
                        @if (isset($hostelConfigs['footer_logo']) && $hostelConfigs['footer_logo'])
                            <img src="{{ asset('storage/images/hostelConfigImages/' . $hostelConfigs['footer_logo']) }}"
                                alt="{{ $hostel->name }} logo" class="w-[150px] h-full" />
                        @else
                            <img src="{{ asset('assets/images/hostelPortal/footer.png') }}" alt="BPMHIRC logo"
                                class="w-[150px] h-full" />
                        @endif
                    </div>
                </div>

                <p class="mt-6 leading-[25px] text-[#FFFFFF]/70 text-base font-light  font-heading">
                    {{ $hostelConfigs['footer_description'] ?? "Nepal's most trusted platform for finding safe, affordable, and student-friendly hostel accommodations across the country." }}
                </p>
                <!-- Socials -->
                <h1 class="mt-4 font-heading text-lg font-medium text-[#fcfcfc]">
                    Follow us
                </h1>
                <div class="mt-2 flex gap-3">
                    @if (isset($hostelConfigs['social_facebook']) && $hostelConfigs['social_facebook'])
                        <a href="{{ $hostelConfigs['social_facebook'] }}"
                            class="grid h-8 w-8 place-items-center rounded-md bg-[#444444] hover:bg-[white] hover:text-[black] transition"
                            aria-label="Facebook">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    @endif
                    @if (isset($hostelConfigs['social_whatsapp']) && $hostelConfigs['social_whatsapp'])
                        <a href="{{ $hostelConfigs['social_whatsapp'] }}"
                            class="grid h-8 w-8 place-items-center rounded-md bg-[#444444] hover:bg-[white] hover:text-[black] transition"
                            aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                    @if (isset($hostelConfigs['social_instagram']) && $hostelConfigs['social_instagram'])
                        <a href="{{ $hostelConfigs['social_instagram'] }}"
                            class="grid h-8 w-8 place-items-center rounded-md bg-[#444444] hover:bg-[white] hover:text-[black] transition"
                            aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Useful Links -->
            <div>
                <h4 class="text-lg font-semibold font-heading text-[#fcfcfc]">Company</h4>
                <img src="{{ asset('assets/images/hostelPortal/underline.png') }}" alt=""
                    class="mt-0 h-1.5 w-[90px] object-contain" />
                <ul class="mt-1 space-y-3 font-heading text-base text-[#fcfcfc]/50">
                    <li>
                        <a href="{{ route('hostel.index', $hostel->slug) }}" class="hover:text-white transition">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hostel.aboutUs', $hostel->slug) }}" class="hover:text-white transition">
                            About
                            us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hostel.room', $hostel->slug) }}" class="hover:text-white transition">
                            Rooms
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hostel.gallery', $hostel->slug) }}" class="hover:text-white  transition">
                            Gallery
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Quicks Links -->
            @php $termsAndPolicies = session('active_hostel')->termsAndPolicies; @endphp
            <div>
                <h4 class="text-lg font-semibold font-heading text-[#fcfcfc]">Legal</h4>
                <img src="{{ asset('assets/images/hostelPortal/underline.png') }}" alt=""
                    class="mt-0 h-1.5 w-[90px] object-contain" />
                <ul class="mt-1 space-y-3 font-heading text-base text-[#fcfcfc]/50">
                    @foreach ($termsAndPolicies as $term)
                        <li>
                            <a href="{{ route('hostel.termsAndPolicy', ['hostel' => session('active_hostel')->slug, 'termSlug' => $term->slug]) }}"
                                class="hover:text-white transition">{{ $term->tp_title }}</a>
                        </li>
                    @endforeach
                    {{-- <li><a href="#" class="hover:text-white transition">Terms of Services</a></li>
                    <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Refund Policy</a></li> --}}
                </ul>
            </div>

            <!-- Contact us -->
            <div>
                <h4 class="text-lg font-semibold font-heading text-[#fcfcfc]">Contact us</h4>
                <img src="{{ asset('assets/images/hostelPortal/underline.png') }}" alt=""
                    class="mt-0 h-1.5 w-[90px] object-contain" />
                <ul class="mt-1 space-y-4 font-heading text-base text-[#fcfcfc]/50">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M4.616 19q-.691 0-1.153-.462T3 17.384V6.616q0-.691.463-1.153T4.615 5h14.77q.69 0 1.152.463T21 6.616v10.769q0 .69-.463 1.153T19.385 19zM20 6.885l-7.552 4.944q-.106.055-.214.093q-.109.037-.234.037t-.234-.037t-.214-.093L4 6.884v10.5q0 .27.173.443t.443.173h14.769q.269 0 .442-.173t.173-.443zM12 11l7.692-5H4.308zM4 6.885v.211v-.811v.034V6v.32v-.052v.828zV18z" />
                        </svg>
                        <span>
                            {{ session('active_hostel')->email }}
                        </span>
                    </li>
                    @if (isset($hostelConfigs['contact_phone_1']))
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19.5 22a1.5 1.5 0 0 0 1.5-1.5V17a1.5 1.5 0 0 0-1.5-1.5c-1.17 0-2.32-.18-3.42-.55a1.51 1.51 0 0 0-1.52.37l-1.44 1.44a14.77 14.77 0 0 1-5.89-5.89l1.43-1.43c.41-.39.56-.97.38-1.53c-.36-1.09-.54-2.24-.54-3.41A1.5 1.5 0 0 0 7 3H3.5A1.5 1.5 0 0 0 2 4.5C2 14.15 9.85 22 19.5 22M3.5 4H7a.5.5 0 0 1 .5.5c0 1.28.2 2.53.59 3.72c.05.14.04.34-.12.5L6 10.68c1.65 3.23 4.07 5.65 7.31 7.32l1.95-1.97c.14-.14.33-.18.51-.13c1.2.4 2.45.6 3.73.6a.5.5 0 0 1 .5.5v3.5a.5.5 0 0 1-.5.5C10.4 21 3 13.6 3 4.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                            <span>
                                +977 {{ $hostelConfigs['contact_phone_1'] }} / {{ $hostelConfigs['contact_phone_2'] }}
                            </span>
                        </li>
                    @endif
                    @if (isset($hostelConfigs['physical_address']) && $hostelConfigs['physical_address'])
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M12.56 20.82a.96.96 0 0 1-1.12 0C6.611 17.378 1.486 10.298 6.667 5.182A7.6 7.6 0 0 1 12 3c2 0 3.919.785 5.333 2.181c5.181 5.116.056 12.196-4.773 15.64" />
                                    <path d="M12 12a2 2 0 1 0 0-4a2 2 0 0 0 0 4" />
                                </g>
                            </svg>
                            <span>
                                {{ $hostelConfigs['physical_address'] }}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- bottom bar -->
    <div class="border-t border-[#D1D5DB]/30">
        <div
            class="mx-auto w-full font-heading font-regular text-xs max-w-12xl px-4 sm:px-6 md:px-[120px] py-4 text-[#fcfcfc]/80 flex flex-col gap-2 items-center justify-between md:flex-row">
            <div>Copyright © 2025 HostelHub. All rights reserved. | Proudly serving students across Nepal &nbsp;
                All rights reserved</div>
            <div>Developed by: <a href="https://omwaytechnologies.com/"
                    class="text-xs font-regular font-heading hover:text-[#5454B1] text-[#fcfcfc]/80">Omway
                    Technology</a>
            </div>
        </div>
    </div>
</footer>
