@extends('layouts/master')

@section('title', 'Seddit')

{{-- Set meta variables to be used in comment reply --}}
<meta name="user_id" content="@guest @else{{ Auth::user()->id }}@endguest">
<meta name="post_id" content="{{ $post->id }}">

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h1 class="h5">
                    (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                    <a id="{{ $post->id }}" class="arrows upvote_arrows">↑</a> 
                    <a id="{{ $post->id }}" class="arrows">↓</a>&nbsp;-&nbsp;
                </h1>

            </div>

            <div class="col-xs-6">
                <h1 class="h4">
                    <a class="post_links" href="{{ $post->url }}" target="_blank">
                        {{ $post->content }}  
                    </a> 
                    - {{ $post->author }}
                </h1>
            </div>
        </div>

        <form class="pt-3 pb-3" autocomplete="off" id="create_form" action="{{ $post->id }}/reply" method="post">
            @csrf
            @guest @else <input required placeholder="type your comment here" class="form-control w-50" type="text" name="comment"><br>@endguest
            <button class="btn btn-outline-dark" type="submit">post comment</button>

            <input hidden class="form-control" type="text" name="user_id" readonly value="@guest @else {{ Auth::user()->id }}@endguest">
            <input hidden class="form-control" type="text" name="replied_to_id" readonly value="0">
            <input hidden class="form-control" type="text" name="post_id" readonly value="{{ $post->id }}">
        </form>
        
        <select class="form-control w-25 mb-2" onChange="window.location.href=this.value" id="sort_order" name="sort">
            <li><option value="/comment/{{ $post->id }}">new</option></li>
            <li><option @if(Request::is('*top')) {{ "selected" }} @endif value="../comment/{{ $post->id }}/top">top</option></li>
        </select>

        <div class="row">
            <ul class="comments_list">
                {{-- Iterate through each post and add to list --}}
                @foreach ($comments as $comment)
                    @if($comment->replied_to_id == 0)
                        <li>
                            <strong>{{ $comment->comment }}</strong>
                            - {{ $post->author }}
                            - (<span class="vote_count comment_vote_count" id="{{ $comment->id }}">{{ $comment->votes }}</span>)
                            - <a id="{{ $comment->id }}" class="arrows upvote_arrows comment_arrows">↑</a> 
                            <a id="{{ $comment->id }}" class="arrows comment_arrows">↓</a>

                            {{-- Show how long ago post was made and exact time/date on hover --}}
                            <span title = "{{ $post->created_at->format('m/d/y h:ma') }}">
                                {{$post->created_at->diffForHumans()}}
                            </span>
                            
                            <br>
                            {{-- Temporarily remove replying functionality until I get it working --}}
                            {{-- @guest <a href="/login">reply</a>
                            @else 
                            <a class="reply" id="{{ $comment->id }}" href="#">reply</a>
                            <div hidden class="reply_section" id="{{ $comment->id }}">
                                <input required class="reply_box" id="{{ $comment->id }}"> 
                                <button class="btn btn-outline-dark post_reply post_reply" id="{{ $comment->id }}">post</button>
                                <button class="btn btn-outline-dark cancel_reply" id="{{ $comment->id}}" href="#">cancel</button>
                            </div>
                            @endguest --}}
                        </li>          
                            
                    @endif
                @endforeach
                
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        // Required token for cross-site request forgery protection
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endsection