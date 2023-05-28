<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <div class="container my-5">

        <!-- Your existing HTML code with Bootstrap classes -->
        <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="body">Comment:</label>
                <textarea name="body" id="body" rows="4" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Bootstrap loading spinner -->
        <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display: none;">
            <span class="sr-only"></span>
        </div>

        <div id="comment-status"></div>

        <!-- Comment list -->
        <div id="comment-list">
            <h3>Comments:</h3>
            <ul class="list-group"></ul>
        </div>

    </div>


    <!-- Include jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your existing JavaScript code -->
    <script>
        $(document).ready(function() {
            $('#comment-form').submit(function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                $('#comment-status').html('');
                $('#loading-spinner').show();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        $('#comment-status').html('Comment submitted successfully.');
                        $('#comment-form')[0].reset();
                        $('.error-message').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        // Add the new comment to the comment list
                        appendComment(response.comment);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');

                            $.each(errors, function(field, messages) {
                                var input = $('#' + field);
                                var errorMessage = '<span class="error-message">' +
                                    messages[0] + '</span>';
                                input.addClass('is-invalid');
                                input.after(errorMessage);
                            });
                        } else {
                            $('#comment-status').html('Error occurred. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#loading-spinner').hide();
                    }
                });
            });

            // Function to append a comment to the comment list
            function appendComment(comment) {
                var listItem = $('<li class="list-group-item">');
                var name = $('<strong>').text(comment.name);
                var commentBody = $('<p>').text(comment.body);

                // Edit button
                var editButton = $('<button class="btn btn-link edit-comment">Edit</button>').click(function() {
                    editComment(comment.id, comment.body);
                });

                // Delete button
                var deleteButton = $('<button class="btn btn-link delete-comment">Delete</button>').click(
                    function() {
                        deleteComment(comment.id);
                    });

                listItem.append(name);
                listItem.append(commentBody);
                listItem.append(editButton);
                listItem.append(deleteButton);

                $('#comment-list ul').prepend(listItem);
            }

            // Retrieve existing comments and populate the comment list
            $.ajax({
                url: '/comments', // Replace with your API endpoint to fetch comments
                type: 'GET',
                success: function(response) {
                    $.each(response.comments, function(index, comment) {
                        appendComment(comment);
                    });
                },
                error: function() {
                    console.log('Error retrieving comments.');
                }
            });

            // Function to handle editing a comment
            function editComment(commentId, currentCommentBody) {
                var newCommentText = prompt('Edit the comment:', currentCommentBody);
                if (newCommentText) {
                    var url = '{{ route('comments.update', ':commentId') }}';
                    url = url.replace(':commentId', commentId);

                    var data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        body: newCommentText
                    };

                    $('#loading-spinner').show();

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Update the comment in the comment list
                            var listItem = $('#comment-list ul').find('[data-comment-id="' + commentId +
                                '"]');
                            listItem.find('p').text(newCommentText);

                            $('#comment-status').html('Comment updated successfully.');
                        },
                        error: function(xhr) {
                            $('#comment-status').html('Error occurred. Please try again.');
                        },
                        complete: function() {
                            $('#loading-spinner').hide();
                        }
                    });
                }
            }

            // Function to handle deleting a comment
            function deleteComment(commentId) {
                var confirmDelete = confirm('Are you sure you want to delete this comment?');
                if (confirmDelete) {
                    var url = '{{ route('comments.destroy', ':commentId') }}';
                    url = url.replace(':commentId', commentId);

                    var data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    };

                    $('#loading-spinner').show();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            // Remove the comment from the comment list
                            var listItem = $('#comment-list ul').find('[data-comment-id="' + commentId +
                                '"]');
                            listItem.remove();

                            $('#comment-status').html('Comment deleted successfully.');
                        },
                        error: function(xhr) {
                            $('#comment-status').html('Error occurred. Please try again.');
                        },
                        complete: function() {
                            $('#loading-spinner').hide();
                        }
                    });
                }
            }
        });
    </script>

</body>

</html>
