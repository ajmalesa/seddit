@extends('layouts/master')

@section('title', 'Seddit')

{{-- Set meta variables to be used in comment reply --}}
<meta name="user_id" content="@guest @else{{ Auth::user()->id }}@endguest">
<meta name="post_id" content="{{ $post->id }}">

@section('content')

    <div class="container">
        <div class="row current_post_row">
            <div class="col-xs-6">
                <h1 class="h5 current_post_links">
                    (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                    @guest 
                        - <a href="/register" class="arrows upvote_arrows current_post_arrows">↑</a> 
                        <a href="/register" class="arrows current_post_arrows">↓</a>&nbsp;-&nbsp;
                    @else 
                        <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == 1) voted_up @endif arrows upvote_arrows current_post_arrows">↑</a> 
                        <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == -1) voted_down @endif arrows current_post_arrows">↓</a>&nbsp;-&nbsp;
                    @endguest
                </h1>
            </div>

            <div class="col-xs-6">
                <h1 class="h4">
                    <a class="post_links" href="{{ $post->url }}" target="_blank" rel="noreferrer">
                        <strong>{{ $post->content }}</strong>
                    </a> 
                    - <a href="/profile/{{ $post->getUserIDByAuthorName($post->author) }}">{{ $post->author }}</a>
                </h1>
            </div>
        </div>

        <div class="sort-comments-row">
            <a class="btn btn-outline-dark @if(Request::is('*home') || !Request::is('*top')) {{ "active" }} @endif" href="../../comment/{{ $post->id }}">new</a>
            <a class="btn btn-outline-dark @if(Request::is('*top')) {{ "active" }} @endif" href="../../comment/{{ $post->id }}/top">top</a>
        </div>

        <div>
            <ul class="comments_list">
                <br />
                {{-- Iterate through each comment and add to list --}}
                @foreach ($comments as $comment)
                    @if($comment->replied_to_id == 0)
                    <div class="comment-chain">
                        <li class="comment-box">
                            <strong>{!! nl2br($comment->makeClickableLinks($comment->comment)) !!}</strong>
                            <br />
                            <a href="/profile/{{ $comment->user_id }}">{{ $comment->getUserName() }}</a>
                            - (<span class="vote_count comment_vote_count" id="{{ $comment->id }}">{{ $comment->votes }}</span>)
                            @guest 
                                - <a href="/register" class="upvote_arrows comment_arrows">↑</a> 
                                <a href="/register" class="comment_arrows">↓</a>
                            @else 
                                - <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == 1) voted_up @endif upvote_arrows comment_arrows">↑</a> 
                                <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == -1) voted_down @endif comment_arrows">↓</a>
                            @endguest

                            {{-- Show how long ago comment was made and exact time/date on hover --}}
                            <span title = "{{ $comment->created_at->format('m/d/y h:ma') }}">
                                {{$comment->created_at->diffForHumans()}}
                            </span>
                            
                            <br />
                            @guest <a href="/login">reply</a> 
                            @else 
                                <a class="reply" id="{{ $comment->id }}" href="#">reply</a>
                                <div hidden class="reply_section" id="{{ $comment->id }}"><br />
                                    <textarea required class="reply_box w-100" id="{{ $comment->id }}"></textarea><br /><br />
                                    <button class="btn btn-outline-dark post_reply post_reply" id="{{ $comment->id }}">post</button>
                                    <button class="btn btn-outline-dark cancel_reply" id="{{ $comment->id}}" href="#">cancel</button>
                                </div>
                            @endguest
                            
                            @if($comment->checkIfExists($comment->id))    
                                <br />
                                @foreach($comment->getReplyByCommentById($comment->id) as $commentReply) 
                                    <br />
                                    <div class="replies">                                        
                                        <strong>{!! nl2br($commentReply->makeClickableLinks($commentReply->comment)) !!}</strong>
                                        <br />
                                        <a href="/profile/{{ $commentReply->user_id }}">{{ $commentReply->getUserName() }}</a>
                                        - (<span class="vote_count comment_vote_count" id="{{ $commentReply->id }}">{{ $commentReply->votes }}</span>)

                                        @guest 
                                            - <a href="/register" class="upvote_arrows comment_arrows">↑</a> 
                                            <a href="/register" class="comment_arrows">↓</a>
                                        @else 
                                            - <a id="{{ $commentReply->id }}" class="arrows @if(Auth::user()->getVoteForComment(Auth::user()->id , $commentReply->id) == 1) voted_up @endif upvote_arrows comment_arrows">↑</a> 
                                            <a id="{{ $commentReply->id }}" class="arrows @if(Auth::user()->getVoteForComment(Auth::user()->id , $commentReply->id) == -1) voted_down @endif comment_arrows">↓</a>
                                        @endguest

                                        {{-- Show how long ago post was made and exact time/date on hover --}}
                                        <span title = "{{ $commentReply->created_at->format('m/d/y h:ma') }}">
                                            {{$commentReply->created_at->diffForHumans()}}
                                        </span>
                                        
                                        <br />     
                                        @guest <a href="/login">reply</a> 
                                        @else 
                                            <a class="reply" id="{{ $commentReply->id }}" href="#">reply</a>
                                            <div hidden class="reply_section" id="{{ $commentReply->id }}"><br />
                                                <textarea required class="reply_box w-100" id="{{ $commentReply->id }}"></textarea><br /><br />
                                                <button class="btn btn-outline-dark post_reply post_reply" id="{{ $commentReply->id }}">post</button>
                                                <button class="btn btn-outline-dark cancel_reply" id="{{ $commentReply->id}}" href="#">cancel</button>
                                            </div>
                                        @endguest

                                        @if($commentReply->checkIfExists($commentReply->id))
                                            <br />
                                            @foreach($commentReply->getReplyByCommentById($commentReply->id) as $commentReply2) 
                                                <br />
                                                <div class="replies">                                        
                                                    <strong>{!! nl2br($commentReply2->makeClickableLinks($commentReply2->comment)) !!}</strong>
                                                    <br />
                                                    <a href="/profile/{{ $commentReply2->user_id }}">{{ $commentReply2->getUserName() }}</a>
                                                    - (<span class="vote_count comment_vote_count" id="{{ $commentReply2->id }}">{{ $commentReply2->votes }}</span>)
                                                    @guest 
                                                        - <a href="/register" class="upvote_arrows comment_arrows">↑</a> 
                                                        <a href="/register" class="comment_arrows">↓</a>
                                                    @else 
                                                        - <a id="{{ $commentReply2->id }}" class="arrows @if(Auth::user()->getVoteForComment(Auth::user()->id , $commentReply2->id) == 1) voted_up @endif upvote_arrows comment_arrows">↑</a> 
                                                        <a id="{{ $commentReply2->id }}" class="arrows @if(Auth::user()->getVoteForComment(Auth::user()->id , $commentReply2->id) == -1) voted_down @endif comment_arrows">↓</a>
                                                    @endguest
            
                                                    {{-- Show how long ago post was made and exact time/date on hover --}}
                                                    <span title = "{{ $commentReply2->created_at->format('m/d/y h:ma') }}">
                                                        {{$commentReply2->created_at->diffForHumans()}}
                                                    </span>

                                                    <br />
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </li>
                    </div>
                    @endif
                @endforeach    
            </ul>
        </div>

        <form class="pt-1 pb-3" autocomplete="off" id="create_form" action="{{ $post->id }}/reply" method="post">
            @csrf
            @guest @else <textarea required placeholder="type your comment here" class="form-control w-50" type="text" name="comment"></textarea><br />@endguest
            <button class="btn btn-outline-dark" @guest @else type="submit" @endguest>post comment</button>

            <input hidden class="form-control" type="text" name="user_id" readonly value="@guest @else {{ Auth::user()->id }}@endguest">
            <input hidden class="form-control" type="text" name="replied_to_id" readonly value="0">
            <input hidden class="form-control" type="text" name="post_id" readonly value="{{ $post->id }}">
        </form>
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