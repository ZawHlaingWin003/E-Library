<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Book::find(request()->bookId)
            ->reviews()
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        return ApiResponse::success($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $review = new Review();
        $review->content = $request->content;
        $review->book_id = $request->bookId;
        $review->user_id = auth()->id();
        $review->save();

        return response()->json([
            'status' => 201,
            'message' => 'Review Noted Successfully!'
        ]);
    }

    public function show(Review $review)
    {
        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $review->content = $request->content;
        $review->update();

        return response()->json([
            'status' => 200,
            'message' => 'Review updated successfully!'
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->noContent();
    }
}
