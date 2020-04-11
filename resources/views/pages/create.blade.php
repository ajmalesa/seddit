@extends('layouts/master')

@section('title', 'Seddit - Create Post')

@section('content')

    <h1 class="display-4">create</h1>

    <form autocomplete="off" id="create_form" action="/create" method="post">
        @csrf
        <input placeholder="content" class="form-control w-50" type="text" name="content"><br>
    <input placeholder="author" class="form-control w-50" type="text" name="author" readonly value="{{ Auth::user()->username }}"><br>
        <input placeholder="url" class="form-control w-50" id="url" type="text" name="url"><br>   
        <button class="btn btn-outline-dark" type="submit">submit</button>
        <button class="btn btn-outline-dark" type="button" value="cancel" onclick="window.location.href='../'">cancel</button>
    </form>

@endsection