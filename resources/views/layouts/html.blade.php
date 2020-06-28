<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="@yield('description', trans('html.description'))"/>
    <meta name="author" content="{{ config('app.name') }}"/>
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link href="{{ url('/img/logo.svg') }}" rel="icon" type="image/svg+xml"/>
    <link href="{{ url('/img/logo.svg') }}" rel="shortcut icon" type="image/svg+xml"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
<div id="app">
    @include('layouts.navbar')
    <div class="container">
        @yield('content')
        @include('layouts.footer')
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
