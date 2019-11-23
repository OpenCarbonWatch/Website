<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="@lang('html.description')"/>
    <meta name="author" content="Open Carbon Watch"/>
    <title>Open Carbon Watch</title>
    <link href="/favicon.ico" rel="icon" type="image/ico"/>
    <link href="/favicon.ico" rel="shortcut icon" type="image/ico"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
@include('layouts.navbar')
<div class="container">
    @yield('content')
    @include('layouts.footer')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
