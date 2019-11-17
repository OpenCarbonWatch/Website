@extends('layouts.html')

@section('content')
    <h1>Open Carbon Watch</h1>
    @include('layouts.navbar')
    <div class="mb-5">
        <h2>@lang('html.jumbo.france-title')</h2>
        @markdownFile('jumbo.france')
        <h2>@lang('html.h2.explore')</h2>
        <div class="row">
            {{--
            <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Advanced search</h5>
                        <p class="card-text">Query the database by organization name, legal type and
                            reporting or regulation status.</p>
                        <a href="{{ route('france-search') }}" class="btn btn-primary mt-auto">Search</a>
                    </div>
                </div>
            </div>
            --}}
            @include('partials.view-card', ['key' => 'regions-departments', 'route' => 'france-regions-departments'])
        </div>
    </div>
@endsection
