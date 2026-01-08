@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>FAQ</h1>
        <ul>
            <li>
                <a href="{{ route('admin.system-faq.index') }}" class="text-primary">Index</a>
            </li>
            <li>Create</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.system-faq.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_id">
                                    <h6>Category <code>*</code></h6>
                                </label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div id="faqContainer">
                            @foreach (old('faq', []) as $key => $faq)
                                <div class="faq-item">
                                    <div class="row">
                                        <input type="hidden" name="faq[{{ $key }}][id]"
                                            value="{{ $key }}" />
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="faq_question">
                                                <h6>Question <code>*</code></h6>
                                            </label>
                                            <input
                                                class="form-control @error('faq.' . $key . '.faq_question') is-invalid @enderror"
                                                id="faq_question" name="faq[{{ $key }}][faq_question]"
                                                type="text" placeholder="Enter question"
                                                value="{{ old('faq.' . $key . '.faq_question') }}" />
                                            @error('faq.' . $key . '.faq_question')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="faq_answer">
                                                <h6>Answer <code>*</code></h6>
                                            </label>
                                            <textarea class="form-control @error('faq.' . $key . '.faq_answer') is-invalid @enderror" rows="3" id="faq_answer"
                                                name="faq[{{ $key }}][faq_answer]" placeholder="Type Here..." />{{ old('faq.' . $key . '.faq_answer') }}</textarea>
                                            @error('faq.' . $key . '.faq_answer')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary btn-sm ms-2 mt-2 mb-2" id="add-faq">+
                            New
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success float-right"><i class="far fa-hand-point-up"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script>
        $(document).ready(function() {
            let faqIndex = {{ count(old('faq', [])) }};

            $('#add-faq').click(function() {
                const faqItem = `
                <div class="faq-item">
                    <div class="row">
                        <input type="hidden" name="faq[${faqIndex}][id]" value="${faqIndex}" />
                        <div class="col-md-6 form-group mb-3">
                            <label for="faq_question">
                                <h6>Question <code>*</code></h6>
                            </label>
                            <input class="form-control" id="faq_question" name="faq[${faqIndex}][faq_question]" type="text" placeholder="Enter title" />
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="faq_answer">
                                <h6>Answer <code>*</code></h6>
                            </label>
                            <textarea class="form-control" rows="3" id="faq_answer" name="faq[${faqIndex}][faq_answer]" placeholder="Type Here..."></textarea>
                        </div>
                    </div>
                </div>
                `;
                $('#faqContainer').append(faqItem);
                faqIndex++;
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            let newFAQCount = 0;

            function addFAQItem() {
                const newIndex = `new_${newFAQCount++}`;
                console.log(newIndex);
                let faqItem = `
                    <div class="faq-item" data-index="${newIndex}">

                        <div class="row">
                            <div class="col-md-5 form-group mb-3">
                                <label><h6>Question<code> *</code></h6></label>
                                <input class="form-control" name="faq[${newIndex}][faq_question]" type="text" placeholder="Enter question" />
                            </div>
                            <div class="col-md-2 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-3 remove-faq">-</button>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label><h6>Answer<code> *</code></h6></label>
                                <textarea class="form-control" rows="3" name="faq[${newIndex}][faq_answer]" placeholder="Type here..."></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#faqContainer').append(faqItem);
            }

            if ($(".faq-item").length === 0) {
                addFAQItem();
            }

            $('#add-faq').on('click', function() {
                addFAQItem();
            });

            $(document).on('click', '.remove-faq', function() {
                $(this).closest('.faq-item').remove();
            });
        });
    </script>
@endsection
