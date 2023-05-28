<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Book::find(request()->bookId)
            ->reviews()
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'reviews' => $reviews
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'response' => $validator->errors()->toArray()
            ]);
        } else {
            $review = new Review();
            $review->content = $request->content;
            $review->book_id = $request->bookId;
            $review->user_id = auth()->id();
            $review->save();

            return response()->json([
                'status' => 201,
                'response' => 'Review Noted Successfully!'
            ]);
        }
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'response' => $validator->errors()->toArray()
            ]);
        } else {
            $review = Review::findOrFail($id);
            $review->content = $request->content;
            $review->update();

            return response()->json([
                'status' => 200,
                'response' => 'Review updated successfully!'
            ]);
        }
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return response()->noContent();
    }
}
