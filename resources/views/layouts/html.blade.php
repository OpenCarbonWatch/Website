<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="@lang('html.description')"/>
    <meta name="author" content="Open Carbon Watch"/>
    <title>Open Carbon Watch</title>
    <link href="{{ url('/img/logo.svg') }}" rel="icon" type="image/svg+xml"/>
    <link href="{{ url('/img/logo.svg') }}" rel="shortcut icon" type="image/svg+xml"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
@include('layouts.navbar')
<div id="app" class="container">
    @yield('content')
    @include('layouts.footer')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
