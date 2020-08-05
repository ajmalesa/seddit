<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>

        <title>@yield('title')</title>
    </head>
    <body>
        <!-- Image and text -->
        <nav class="mb-4 navbar navbar-dark bg-dark navbar-expand-md">
            <div class="container">
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand" href="/home">
                        seddit
                    </a>
                </ul>

                <div class="navbar-brand form-inline ml-auto">
                    @guest 
                        <a class="navbar-brand mr-1" href="/login">
                            login
                        </a>
                        <a class="navbar-brand" href="/register">
                            register
                        </a>
                    @else
                        <span class="mr-1">{{ Auth::user()->username }}</span>
                        <a class="navbar-brand" href="{{ route('logout') }}">
                            {{ __('logout') }}
                        </a>
                    @endguest
                </div>
            </div> 
        </nav>
        
        <div class="container">
            @yield('content')
        </div>

        <script src="{{ asset('js/voting.js') }}"></script>
        <script src="{{ asset('js/comment.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>