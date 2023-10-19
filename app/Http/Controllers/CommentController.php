<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   // Method to store a new comment
   public function store(Request $request)
   {
       // Validation rules for the comment
       $this->validate($request, [
           'post_id' => 'required|exists:posts,id',
           'message' => 'required',
       ]);

       // Create a new comment and associate it with the post
       $comment = Comment::create([
           'user_id' => auth()->id(),
           'post_id' => $request->post_id,
           'message' => $request->message,
       ]);

       // Redirect back to the post's page after adding the comment
       return redirect()->route('posts.show', $request->post_id);
   }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        // Add an authorization check to ensure the user can edit the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You are not authorized to edit this comment.');
        }
    
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        // Validate the request
        $this->validate($request, [
            'message' => 'required',
        ]);

        // Check if the authenticated user is the owner of the comment
    

        // Update the comment with the new message
        $comment->message = $request->input('message');
        $comment->save();

        // You can return a success response here, e.g., redirect to the post's page
        return response()->json(['message' => 'Comment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        // Add an authorization check to ensure the user can delete the comment
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You are not authorized to delete this comment.');
        }
    
        $post_id = $comment->post_id;
        $comment->delete();
    
        return redirect()->route('posts.show', $post_id)->with('success', 'Comment deleted successfully.');
    }
}
