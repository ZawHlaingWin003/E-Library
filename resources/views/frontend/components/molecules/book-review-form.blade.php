<div class="reviews card my-5">
    <div class="card-header">
        <strong>Total Reviews (<span id="total-reviews"></span>)</strong>
    </div>
    <div class="card-body">

        @if (session('success'))
            <p class="alert alert-success my-2">{{ session('success') }}</p>
        @endif
        @auth
            <form action="{{ route('review.store') }}" method="POST" id="add-review-form">
                <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <x-form-group label="Book Review : " class="mb-2">
                    <x-form-textarea class="review-field" name="content" id="content-field"></x-form-textarea>
                </x-form-group>
                <x-main-button type="submit" buttonId="add-review-button" loaderId="add-review-button-loader" iconId="add-review-button-icon" iconName="fa-comment">
                    Add Review
                </x-main-button>
            </form>
        @else
            <h3 class="text-center">
                You have to login to review books.
                <a href="{{ route('login') }}" class="btn btn-primary primary-btn">Login</a>
            </h3>
        @endauth
    </div>
</div>
