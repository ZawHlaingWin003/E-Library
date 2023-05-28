<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showForm()
    {
        return view('comments.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'body' => 'required',
        ]);

        $comment = Comment::create($validatedData);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function index()
    {
        $comments = Comment::all();

        return response()->json([
            'comments' => $comments
        ]);
    }

    public function edit(Comment $comment)
    {
        // Return the view for editing the comment
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        // Validate the request data
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        // Update the comment
        $comment->body = $request->input('body');
        $comment->save();

        // Return a response indicating the successful update
        return response()->json([
            'message' => 'Comment updated successfully.',
        ]);
    }

    public function destroy(Comment $comment)
    {
        // Delete the comment
        $comment->delete();

        // Return a response indicating the successful deletion
        return response()->json([
            'message' => 'Comment deleted successfully.',
        ]);
    }
}
