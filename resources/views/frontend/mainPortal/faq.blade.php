@extends('frontend.layouts.mainPortal')

@section('body')
    <!-- FAQ's Banner start -->
    <section class="bg-[#e0e2e5] w-full h-[70px] flex items-center sticky top-[88px] z-10">
        <div
            class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-[120px] flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Left Section -->
            <h1 class="text-2xl sm:text-[24px] font-bold text-color mb-2 sm:mb-0 font-heading">Frequently Asked Questions
            </h1>

            <!-- Right Section (Breadcrumb) -->
            <nav class="text-base font-medium text-color font-heading flex items-center space-x-0.5">
                <a href="{{ route('home') }}" class="hover:underline font-heading">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="4" d="m19 12l12 12l-12 12" />
                </svg>
                <span class="text-[#535b6a]">FAQ's</span>
            </nav>
        </div>
    </section>
    <!-- FAQ's Banner end -->

    <!-- FAQ's Section start -->
    <div class="px-6 md:px-20 lg:px-32 py-12 bg-gray-50 min-h-screen">
        <!-- Heading -->
        <div class="text-center">
            <h1 class="text-2xl md:text-4xl font-extrabold text-color font-heading mb-3">
                Frequently Asked Questions
            </h1>
            <p class="sub-text font-heading font-regular text-base mt-3.5 text-center">
                Find answers to common questions about our hostel, facilities, and booking process
            </p>
        </div>

        <!-- Search Bar -->
        <div class="flex justify-center mt-5">
            <div class="w-full max-w-3xl">
                <div class="flex items-center bg-white border border-color box-shadow rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-4 text-[#21282C]/80" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                    </svg>
                    <input id="searchInput" type="text" placeholder="Search questions ..."
                        class="w-full px-2 py-3 font-light bg-transparent font-heading text-[#151515]/60 focus:outline-none" />
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mt-5 font-heading text-sm">
            @foreach ($groupedFaqs as $category => $items)
                <button onclick="setTab('{{ $category }}')" id="tab-{{ $category }}"
                    class="tab-btn px-5 py-2 rounded-full font-medium {{ $loop->first ? 'active-tab bg-[#4490D9] text-white' : 'bg-[#FAFAFA] text-gray-800 border border-[#E1DFDF] hover:bg-[#7790c2]/5' }}">
                    {{ ucfirst($category) }}
                </button>
            @endforeach
        </div>

        <!-- FAQs -->
        <div class="max-w-3xl mx-auto space-y-4 mt-5" id="faq-container"></div>
    </div>

    <script>
        const faqs = {!! $faqsJson !!};
        let currentTab = Object.keys(faqs)[0] ?? "all";

        function setTab(tab) {
            currentTab = tab;
            document.querySelectorAll(".tab-btn").forEach(btn => {
                btn.classList.remove("active-tab", "bg-[#4490D9]", "text-white", "cursor-default");
                btn.classList.add("bg-[#FAFAFA]", "text-gray-800", "border", "border-[#E1DFDF]",
                    "hover:bg-[#7790c2]/5", "cursor-pointer");
            });

            const activeBtn = document.getElementById(`tab-${tab}`);
            activeBtn.classList.remove("bg-[#FAFAFA]", "text-gray-800", "border", "border-[#E1DFDF]",
                "hover:bg-[#7790c2]/5", "cursor-pointer");
            activeBtn.classList.add("active-tab", "bg-[#4490D9]", "text-white", "cursor-default");

            renderFaqs(document.getElementById("searchInput").value);
        }

        function renderFaqs(filterText = "") {
            const container = document.getElementById("faq-container");
            container.innerHTML = "";

            const selectedFaqs = currentTab === "all" ?
                faqs["all"] :
                faqs[currentTab] || [];

            const filteredFaqs = selectedFaqs.filter(item =>
                item.q.toLowerCase().includes(filterText.toLowerCase())
            );

            if (filteredFaqs.length === 0) {
                container.innerHTML = `<p class='text-center text-gray-500 py-6'>No matching questions found.</p>`;
                return;
            }

            filteredFaqs.forEach((item) => {
                const faq = document.createElement("div");
                faq.className =
                    "bg-white rounded-[8px] border border-gray-200 shadow-sm overflow-hidden transition-all duration-500";
                faq.innerHTML = `
                <button onclick="toggleAccordion(this)"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-[#7790c2]/5 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <span class="text-base font-medium text-gray-900">${item.q}</span>
                        ${item.tag ? `<span class="px-3 py-1 text-xs bg-[#e5eeff]/60 text-[#4e81f2] rounded-full font-medium w-fit">${item.tag}</span>` : ""}
                    </div>
                    <span class="plus-icon text-2xl font-light text-gray-900 flex-shrink-0 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" d="M6 12h6m6 0h-6m0 0V6m0 6v6" />
                        </svg>
                    </span>
                </button>
                <div class="accordion-content overflow-hidden transition-all duration-500 ease-in-out max-h-0">
                    <div class="px-5 pb-6 mt-4 text-gray-600 leading-[25px] text-base">
                        ${item.a}
                    </div>
                </div>
            `;
                container.appendChild(faq);
            });
        }

        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector(".plus-icon");
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                icon.classList.remove("rotate-45");
            } else {
                document.querySelectorAll(".accordion-content").forEach(c => c.style.maxHeight = null);
                document.querySelectorAll(".plus-icon").forEach(i => i.classList.remove("rotate-45"));
                content.style.maxHeight = content.scrollHeight + "px";
                icon.classList.add("rotate-45");
            }
        }

        document.getElementById("searchInput").addEventListener("input", (e) => {
            renderFaqs(e.target.value);
        });

        // Default tab
        setTab(currentTab);
    </script>


    <!--  FAQ's Section end-->
@endsection
