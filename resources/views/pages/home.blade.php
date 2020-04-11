@extends('layouts/master')

@section('title', 'Seddit')

@section('content')
    
    <select class="form-control w-25 mb-2" onChange="window.location.href=this.value" id="sort_order" name="sort">
        <li><option value="/">new</option></li>
        <li><option @if(Request::is('*top')) {{ "selected" }} @endif value="top">top</option></li>
    </select>

    <ol>
        {{-- Iterate through each post and add to list --}}
        @foreach ($posts as $post)
            <li>
                <a class="post_links" href="{{ $post->url }}" target="_blank">
                    <strong>{{ $post->content }}</strong>
                </a> 
                - {{ $post->author }}
                - (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                - <a id="{{ $post->id }}" class="arrows upvote_arrows">↑</a> 
                <a id="{{ $post->id }}" class="arrows">↓</a>
            </li> 
            
            <a href="/comment/{{ $post->id }}"> comments</a>

            {{-- Show how long ago post was made and exact time/date on hover --}}
            <span title = "{{ $post->created_at->format('m/d/y h:ma') }}">
                {{ $post->created_at->diffForHumans() }}
            </span>            
        @endforeach
    </ol>

    <a class="btn btn-outline-dark" href="create"><span class="submit">submit new post</span></a>

    <script type="text/javascript">
        // Required token for cross-site request forgery protection
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Run this code when arrow is clicked
        $(document).on('click', '.arrows', function() {

            // Initialize point that will be added to 0, which will be changed 
            // depending on which arrow was selected
            var point = 0;

            // If the arrow that was clicked has a class of upvote_arrows, set
            // point to a positive 1, otherwise set to negative 1 and change 
            // classes to update colors to match vote
            if($(this).hasClass('upvote_arrows') && !$(this).hasClass('voted_up')) {
                point += 1;
                $(this).addClass('voted_up');
            } else if(!$(this).hasClass('upvote_arrows') && !$(this).hasClass('voted_down')) {
                point -= 1;
                $(this).addClass('voted_down');
            } else if ($(this).hasClass('upvote_arrows') && $(this).hasClass('voted_up')) { 
                // Remove upvote class when button if upvote button is clicked again
                // and remove class to change color back to default
                point -= 1;
                $(this).removeClass('voted_up');
            } else if (!$(this).hasClass('upvote_arrows') && $(this).hasClass('voted_down')) { 
                // Remove downvote class when button if downvote button is clicked again
                // and remove class to change color back to default
                point += 1;
                $(this).removeClass('voted_down');
            } 

            // Set the id to that will be sent in ajax post to the id from the 
            // post that the arrows was clicked on
            var id = this.id;

            // Update point count for post being updated in real time,
            // for just the front end for real time user feedback on votes
            $("#" + id)[0].innerHTML = parseInt($("#" + id)[0].innerHTML) + point;

            // Send AJAX post to index page '/' with the id of post to update
            // and point amount to increment or decrement by
            $.ajax({
                type:'POST',
                url:'/',
                data:{id:id, point:point}      
            });
        });
    </script>

@endsection