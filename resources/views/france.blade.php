@extends('layouts.html')

@section('content')
    <div class="mb-5">
        <h1>@lang('html.jumbo.france-title')</h1>
        <h2>@lang('html.h2.legal')</h2>
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
            @include('partials.view-card', ['key' => 'city-groups', 'route' => 'france-city-groups'])
            @include('partials.view-card', ['key' => 'cities', 'route' => 'france-cities'])
            @include('partials.view-card', ['key' => 'state', 'route' => 'france-state'])
            @include('partials.view-card', ['key' => 'other-public', 'route' => 'france-other-public'])
            @include('partials.view-card', ['key' => 'companies', 'route' => 'france-companies'])
            @include('partials.view-card', ['key' => 'specialized-private', 'route' => 'france-specialized-private'])
            @include('partials.view-card', ['key' => 'associations', 'route' => 'france-associations'])
        </div>
    </div>
@endsection
