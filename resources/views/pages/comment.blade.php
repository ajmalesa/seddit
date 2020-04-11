@extends('layouts/master')

@section('title', 'Seddit')

@section('content')

    <h1 class="display-4">{{ $post->content }}</h1>

    <script type="text/javascript">
        // Required token for cross-site request forgery protection
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endsection