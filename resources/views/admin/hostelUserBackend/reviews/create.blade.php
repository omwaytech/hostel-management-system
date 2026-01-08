@extends('admin.layouts.hostelUserBackend')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Rate Your Experience</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('resident.hostels') }}"><i class="fas fa-home"></i>
                                    All Hostels</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('resident.hostels.show', $hostel->id) }}">{{ $hostel->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Write Review</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if ($hostel->logo)
                            <img src="{{ asset('storage/images/hostelLogo/' . $hostel->logo) }}" alt="{{ $hostel->name }}"
                                style="max-height: 80px; object-fit: contain;">
                        @endif
                        <h3 class="mt-3">{{ $hostel->name }}</h3>
                        <p class="text-muted">Share your experience with this hostel</p>
                    </div>

                    <form action="{{ route('resident.reviews.store') }}" method="POST" id="reviewForm">
                        @csrf
                        <input type="hidden" name="hostel_id" value="{{ $hostel->id }}">

                        {{-- Star Rating --}}
                        <div class="form-group">
                            <label class="form-label"><strong>Your Rating</strong> <span
                                    class="text-danger">*</span></label>
                            <div class="star-rating-container">
                                <div class="star-rating" id="starRating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            id="star{{ $i }}" required>
                                        <label for="star{{ $i }}" title="{{ $i }} stars">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                <div class="rating-text mt-2" id="ratingText">Click to rate</div>
                            </div>
                            @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Review Text --}}
                        <div class="form-group">
                            <label class="form-label"><strong>Your Review</strong> (Optional)</label>
                            <textarea name="review_text" class="form-control @error('review_text') is-invalid @enderror" rows="6"
                                maxlength="1000" placeholder="Tell us about your experience... What did you like? What could be improved?">{{ old('review_text') }}</textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                            @error('review_text')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Review
                            </button>
                            <a href="{{ route('resident.hostels.show', $hostel->id) }}"
                                class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .star-rating-container {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .star-rating {
            direction: rtl;
            display: inline-flex;
            font-size: 0;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            padding: 0 5px;
            font-size: 40px;
            color: #ddd;
            transition: color 0.2s;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #fbbf24;
        }

        .rating-text {
            font-size: 16px;
            font-weight: 500;
            color: #666;
        }

        .rating-text.selected {
            color: #fbbf24;
            font-weight: 600;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const ratingLabels = {
                1: '1 Star - Poor',
                2: '2 Stars - Fair',
                3: '3 Stars - Good',
                4: '4 Stars - Very Good',
                5: '5 Stars - Excellent'
            };

            // Handle star rating display
            $('input[name="rating"]').change(function() {
                const rating = $(this).val();
                $('#ratingText').text(ratingLabels[rating]).addClass('selected');
            });

            // Character counter for review text
            const maxChars = 1000;
            $('textarea[name="review_text"]').on('input', function() {
                const remaining = maxChars - $(this).val().length;
                $(this).next('small').text(`${remaining} characters remaining`);
            });
        });
    </script>
@endsection
