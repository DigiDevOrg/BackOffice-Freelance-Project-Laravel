@extends("layouts/contentNavbarLayout")
@section("title", $post->title)
@section("content")

<h1>{{ $post->title }}</h1>

<img src="{{ asset('storage/'.$post->picture) }}" alt="Image de couverture" style="max-width: 300px;">

<div>{{ $post->content }}</div>
<p><a href="{{ route('posts.index') }}" title="Return to articles">Return to posts</a></p>
<!-- Display comments -->
<h2>Comments</h2>


<!-- Add a new comment form -->
@auth
    <form action="{{ route('comments.store') }}" method="post">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <textarea name="message"  class="form-control" placeholder="Add a comment"></textarea>
        <button type="submit" class="btn btn-primary mt-2 mb-4">Submit Comment</button>
    </form>
@else
    <p>Please <a href="{{ route('login') }}">log in</a> to leave a comment.</p>
@endauth

@if ($post->comments->count() > 0)
    @foreach ($post->comments as $comment)
    <div class="card mb-3">
  <div class="card-body">
        
            <strong>{{ $comment->user->name }}:</strong>
            <span class="comment-content" data-comment-id="{{ $comment->id }}">{{ $comment->message }}</span>
            
            @auth
                @if ($comment->user_id === auth()->id())
                    <div style="display: flex; align-items: center;">
                        <button class="edit-comment btn btn-info" data-comment-id="{{ $comment->id }}" style="margin-right: 10px;">Edit</button>
                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        </div>
    @endforeach
@else
    <p>No comments yet.</p>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Function to enable editing
    function enableCommentEditing(commentId) {
        var commentContent = $(`.comment-content[data-comment-id="${commentId}"]`);
        var editButton = $(`.edit-comment[data-comment-id="${commentId}"]`);
        var commentInput = $(`<input type="text" class="comment-input" data-comment-id="${commentId}" value="${commentContent.text()}">`);

        // Replace the comment content with an input field
        commentContent.replaceWith(commentInput);

        // Change the button to "Save"
        editButton.text("Save");

        // Handle the "Save" button click
        editButton.off("click").click(function () {
            var updatedComment = commentInput.val();

            // Send an AJAX request to update the comment
            $.ajax({
                url: `{{ route('comments.update', '') }}/${commentId}`,
                type: "PUT",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "message": updatedComment
                },
                success: function (data) {
                    // Update the comment content
                    commentContent.text(updatedComment);

                    // Change the button back to "Edit"
                    editButton.text("Edit");

                    // Re-enable editing
                    enableCommentEditing(commentId);
                },
                error: function (xhr) {
                    // Handle errors if needed
                    console.log(xhr.responseText);
                }
            });
        });
    }

    $(".edit-comment").click(function () {
        var commentId = $(this).data("comment-id");
        enableCommentEditing(commentId);
    });
});

</script>




@endsection
