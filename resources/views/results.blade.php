@extends('layouts.html')

@section('content')
    <h1>Open Carbon Watch</h1>
    @include('layouts.navbar')
    <div class="mb-5">
        <h2>@lang($title)</h2>
        <p><i>@lang('results.disclaimer')</i></p>
        {{-- Results --}}
    </div>
@endsection
