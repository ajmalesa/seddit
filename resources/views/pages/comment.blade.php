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
                    <a id="{{ $post->id }}" class="arrows upvote_arrows current_post_arrows">↑</a> 
                    <a id="{{ $post->id }}" class="arrows current_post_arrows">↓</a>&nbsp;-&nbsp;
                </h1>
            </div>

            <div class="col-xs-6">
                <h1 class="h4">
                    <a class="post_links" href="{{ $post->url }}" target="_blank">
                        <strong>{{ $post->content }}</strong>
                    </a> 
                    - {{ $post->author }}
                </h1>
            </div>
        </div>

        <form class="pt-3 pb-3" autocomplete="off" id="create_form" action="{{ $post->id }}/reply" method="post">
            @csrf
            @guest @else <textarea required placeholder="type your comment here" class="form-control w-75" type="text" name="comment"></textarea><br>@endguest
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
                        <hr>
                        <li>
                            <strong>{!! nl2br($comment->makeClickableLinks($comment->comment)) !!}</strong>
                            <br>

                            {{ $comment->getUserName() }}
                            - (<span class="vote_count comment_vote_count" id="{{ $comment->id }}">{{ $comment->votes }}</span>)
                            - <a id="{{ $comment->id }}" class="arrows upvote_arrows comment_arrows">↑</a> 
                            <a id="{{ $comment->id }}" class="arrows comment_arrows">↓</a>

                            {{-- Show how long ago post was made and exact time/date on hover --}}
                            <span title = "{{ $comment->created_at->format('m/d/y h:ma') }}">
                                {{$comment->created_at->diffForHumans()}}
                            </span>
                            
                            <br>
                            
                            @guest <a href="/login">reply</a> 
                            @else 
                            <a class="reply" id="{{ $comment->id }}" href="#">reply</a>
                            <div hidden class="reply_section" id="{{ $comment->id }}"><br>
                                <textarea required class="reply_box w-100" id="{{ $comment->id }}"></textarea><br><br>
                                <button class="btn btn-outline-dark post_reply post_reply" id="{{ $comment->id }}">post</button>
                                <button class="btn btn-outline-dark cancel_reply" id="{{ $comment->id}}" href="#">cancel</button>
                            </div>
                            @endguest
                            

                            @if($comment->checkIfExists($comment->id))
                                <br>
                                @foreach($comment->getReplyByCommentById($comment->id) as $commentReply) 
                                    <br>
                                    <div class="replies">                                        
                                        <strong>{!!  nl2br(e($commentReply->comment)) !!}</strong>
                                        
                                        <br>

                                        {{ $commentReply->getUserName() }}
                                        - (<span class="vote_count comment_vote_count" id="{{ $commentReply->id }}">{{ $commentReply->votes }}</span>)
                                        - <a id="{{ $commentReply->id }}" class="arrows upvote_arrows comment_arrows">↑</a> 
                                        <a id="{{ $commentReply->id }}" class="arrows comment_arrows">↓</a>

                                        {{-- Show how long ago post was made and exact time/date on hover --}}
                                        <span title = "{{ $commentReply->created_at->format('m/d/y h:ma') }}">
                                            {{$commentReply->created_at->diffForHumans()}}
                                        </span>
                                        
                                        <br>
                                        
                                        @guest <a href="/login">reply</a> 
                                        @else 
                                        <a class="reply" id="{{ $commentReply->id }}" href="#">reply</a>
                                        <div hidden class="reply_section" id="{{ $commentReply->id }}">
                                            <input required class="reply_box" id="{{ $commentReply->id }}"> 
                                            <button class="btn btn-outline-dark post_reply post_reply" id="{{ $commentReply->id }}">post</button>
                                            <button class="btn btn-outline-dark cancel_reply" id="{{ $commentReply->id}}" href="#">cancel</button>
                                        </div>
                                        @endguest


                                        @if($commentReply->checkIfExists($commentReply->id))
                                            <br>
                                            @foreach($commentReply->getReplyByCommentById($commentReply->id) as $commentReply2) 
                                                <br>
                                                <div class="replies">                                        
                                                    <strong>{!!  nl2br(e($commentReply2->comment)) !!}</strong>
                                                    
                                                    <br>
            
                                                    {{ $commentReply2->getUserName() }}
                                                    - (<span class="vote_count comment_vote_count" id="{{ $commentReply2->id }}">{{ $commentReply2->votes }}</span>)
                                                    - <a id="{{ $commentReply2->id }}" class="arrows upvote_arrows comment_arrows">↑</a> 
                                                    <a id="{{ $commentReply2->id }}" class="arrows comment_arrows">↓</a>
            
                                                    {{-- Show how long ago post was made and exact time/date on hover --}}
                                                    <span title = "{{ $commentReply2->created_at->format('m/d/y h:ma') }}">
                                                        {{$commentReply2->created_at->diffForHumans()}}
                                                    </span>
                                                    
                                                    <br>
                                                    
                                                    @guest <a href="/login">reply</a> 
                                                    @else 
                                                    <a class="reply" id="{{ $commentReply2->id }}" href="#">reply</a>
                                                    <div hidden class="reply_section" id="{{ $commentReply2->id }}">
                                                        <input required class="reply_box" id="{{ $commentReply2->id }}"> 
                                                        <button class="btn btn-outline-dark post_reply post_reply" id="{{ $commentReply2->id }}">post</button>
                                                        <button class="btn btn-outline-dark cancel_reply" id="{{ $commentReply2->id}}" href="#">cancel</button>
                                                    </div>
                                                    @endguest
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>
                                @endforeach
                            @endif
                        </li>
                        <hr>
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