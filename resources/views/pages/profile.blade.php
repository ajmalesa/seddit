@extends('layouts/master')

@section('title', 'Seddit')


@section('content')

    <div class="container">
        <h1 class="h2">{{ $user->username }}</h1>
            <div class="row">
                <div class="col-md-8">
                    <div class="posts-list">
                        <h2 class="h4">posts</h2>
                        @foreach ($posts as $post)
                            <div class="individual_post">
                                <li>
                                    <a class="post_links" href="{{ $post->url }}" target="_blank">
                                        <strong>{{ $post->content }}</strong>
                                    </a> 
                                    - (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                                    @if (Auth::check())
                                        - <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == 1) voted_up @endif arrows upvote_arrows all_posts_arrow">↑</a> 
                                        <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == -1) voted_down @endif arrows all_posts_arrow">↓</a>
                                    @else 
                                        - <a href="/register" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                                        <a href="/register" class="arrows all_posts_arrow">↓</a>
                                    @endif
                                    - <a href="/comment/{{ $post->id }}">link</a>
                                </li> 
                            </div>
                        @endforeach
                    </div>

                    <div class="comments-list">
                        <h2 class="h4">comments</h2>
                        @foreach ($comments as $comment)
                            <div class="individual_post">
                                <li class="comment-box">
                                    <strong>{!! nl2br($comment->makeClickableLinks($comment->comment)) !!}</strong>

                                    {{-- Placeholder span so voting js still works correctly by targeting the correct index for elements --}}
                                    <span></span>
                                    
                                    - (<span class="vote_count comment_vote_count" id="{{ $comment->id }}">{{ $comment->votes }}</span>)
                                    @guest 
                                        - <a href="/register" class="upvote_arrows comment_arrows">↑</a> 
                                        <a href="/register" class="comment_arrows">↓</a>
                                    @else 
                                        - <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == 1) voted_up @endif upvote_arrows comment_arrows">↑</a> 
                                        <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == -1) voted_down @endif comment_arrows">↓</a>
                                    @endguest

                                    - <a href="/comment/{{ $comment->post_id }}">link</a>
                                </li> 
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4 awards-column">
                    <h2 class="h4">awards</h2>
                    <div class="row awards-row">
                        @if ($user->getTotalPostVotes() >= 10)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cd7f32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                                <p>10 post points</p>
                            </div>
                        @endif
                        @if ($user->getTotalPostVotes() >= 50)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#c0c0c0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                                <p>50 post points</p>
                            </div>
                        @endif
                        @if ($user->getTotalPostVotes() >= 100)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ffd700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                                <p>100 post points</p>
                            </div>
                        @endif
                        @if ($user->getTotalCommentVotes() >= 10)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cd7f32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p>10 comment points</p>
                            </div>
                        @endif
                        @if ($user->getTotalCommentVotes() >= 50)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#c0c0c0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p>50 comment points</p>
                            </div>
                        @endif
                        @if ($user->getTotalCommentVotes() >= 100)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ffd700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p>100 comment points</p>
                            </div>
                        @endif

                        @if($user->getUserAccountAge() >= 30)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cd7f32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <p>1 month account</p>
                            </div>
                        @endif
                        @if($user->getUserAccountAge() >= 180)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#c0c0c0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <p>6 month account</p>
                            </div>
                        @endif
                        @if($user->getUserAccountAge() >= 365)
                            <div class="col-md-12 col-lg-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ffd700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <p>1 year account</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>

@endsection
