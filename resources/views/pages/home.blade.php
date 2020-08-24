@extends('layouts/master')

@section('title', 'Seddit')

@section('content')
    
    {{-- <select class="form-control w-25 mb-2" onChange="window.location.href=this.value" id="sort_order" name="sort">
        <li><option value="home">new</option></li>
        <li><option @if(Request::is('*top')) {{ "selected" }} @endif value="top">top</option></li>
    </select> --}}

    <a class="btn btn-outline-dark @if(Request::is('*home') || !Request::is('*top')) {{ "active" }} @endif" href="/home">new</a>
    <a class="btn btn-outline-dark @if(Request::is('*top')) {{ "active" }} @endif" href="/top">top</a>
    
    <ol class="posts_list">
        <br />
        {{-- Iterate through each post and add to list --}}
        @foreach ($posts as $post)
            @if ($post->votes < 0) 
                <span id="hiddenPostMessage-{{ $post->id }}" class="hiddenPostMessageClass">
                    <p class="hiddenPostParagraphTag">post hidden due to downvotes <button class="btn btn-outline-danger btn-sm show-post-class" id="showPostID-{{ $post->id }}">show</button></p> 
                    
                </span>
                <div class="individual_post d-none" id="hiddenPostID-{{ $post->id }}"> 
                    <li>
                        <a class="post_links" href="{{ $post->url }}" target="_blank">
                            <strong>{{ $post->content }}</strong>
                        </a> 
                        - {{ $post->author }}
                        - (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                        @if (Auth::check())
                            - <a id="{{ $post->id }}" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                            <a id="{{ $post->id }}" class="arrows all_posts_arrow">↓</a>
                        @else 
                            - <a href="/register" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                            <a href="/register" class="arrows all_posts_arrow">↓</a>
                        @endif
                    </li> 
                    
                    <a href="comment/{{ $post->id }}"> {{ $comments->where('post_id', $post->id)->count() }} comments</a>
                    {{-- {{ $users->where('user_id', $comment->user_id)->count() }} --}}

                    @if (Auth::check() && Auth::user()->username == $post->author)
                            <a href="delete/{{ $post->id }}">delete</a>
                    @endif

                    {{-- Show how long ago post was made and exact time/date on hover --}}
                    <span title = "{{ $post->created_at->format('m/d/y h:ma') }}">
                        {{ $post->created_at->diffForHumans() }}
                    </span>  

                </div>
            @else
                <div class="individual_post">
                    
                    <li>
                        <a class="post_links" href="{{ $post->url }}" target="_blank">
                            <strong>{{ $post->content }}</strong>
                        </a> 
                        - {{ $post->author }}
                        - (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                        @if (Auth::check())
                            - <a id="{{ $post->id }}" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                            <a id="{{ $post->id }}" class="arrows all_posts_arrow">↓</a>
                        @else 
                            - <a href="/register" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                            <a href="/register" class="arrows all_posts_arrow">↓</a>
                        @endif
                    </li> 
                    
                    <a href="comment/{{ $post->id }}"> {{ $comments->where('post_id', $post->id)->count() }} comments</a>
                    {{-- {{ $users->where('user_id', $comment->user_id)->count() }} --}}

                    @if (Auth::check() && Auth::user()->username == $post->author)
                            <a href="delete/{{ $post->id }}">delete</a>
                    @endif

                    {{-- Show how long ago post was made and exact time/date on hover --}}
                    <span title = "{{ $post->created_at->format('m/d/y h:ma') }}">
                        {{ $post->created_at->diffForHumans() }}
                    </span>    

                </div>
            @endif
        @endforeach
    </ol>
    <br />

    <div class="submit-container">
        <a class="btn btn-outline-dark" href="create"><span class="submit">submit post</span></a>
    </div>

@endsection