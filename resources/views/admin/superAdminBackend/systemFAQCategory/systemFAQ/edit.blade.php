@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>FAQ</h1>
            <ul>
                <li>
                    <a href="{{ route('admin.system-faq.index') }}"class="text-primary">Index</a>
                </li>
                <li>Edit</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form action="{{ route('admin.system-faq.update', $faq->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 form-group mb-3">
                                    <label for="category_id">
                                        <h6>FAQ Category <code>*</code></h6>
                                    </label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                        <option value="" disabled
                                            {{ old('category_id', $faq->category_id ?? '') == '' ? 'selected' : '' }}>
                                            Choose category
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $faq->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $loop->index + 1 }} | {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="faq_question">
                                        <h6>Question<code> *</code></h6>
                                    </label>
                                    <input class="form-control @error('faq_question') is-invalid @enderror"
                                        id="faq_question" name="faq_question" type="text" placeholder="Enter name"
                                        value="{{ old('faq_question', $faq->faq_question ?? '') }}" />
                                    @error('faq_question')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="faq_answer">
                                        <h6>Answer<code> *</code></h6>
                                    </label>
                                    {{-- <input class="form-control @error('faq_answer') is-invalid @enderror" id="faq_answer"
                                        name="faq_answer" type="text" placeholder="Enter faq_answer"
                                        value="{{ old('faq_answer', $faq->faq_answer ?? '') }}" /> --}}
                                    <textarea class="form-control @error('faq_answer') is-invalid @enderror" rows="4" id="faq_answer"
                                        name="faq_answer" placeholder="Type Here..." />{{ old('faq_answer', $faq->faq_answer ?? '') }}</textarea>
                                    @error('faq_answer')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-success float-right"><i class="far fa-hand-point-up"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
