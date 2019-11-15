<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="We monitor greenhouse gases emissions reports published by public and private organizations, along with their legal obligations and their own commitments, and track them over time."/>
    <meta name="author" content="OCW"/>
    <title>Open Carbon Watch</title>
    {{-- Insert yarn generated CSS and JS resources --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
    <link href="{{ mix('js/app.js') }}" rel="stylesheet"/>
</head>
<body>
<div class="container">
    @yield('content')
    @include('layouts.footer')
</div>
</body>
</html>
