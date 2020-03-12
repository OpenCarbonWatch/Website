@extends('layouts.html')

@section('content')
    <div class="mb-5">
        <h2>@lang('html.view-card.search.title')</h2>
        {{ Form::open(['route' => 'france-search-build']) }}
        {{ Form::token() }}
        <div class="form-group">
            <label for="name">@lang('html.search.name')</label>
            <input id="name" name="name" class="form-control"/>
        </div>
        <autocomplete-activity></autocomplete-activity>
        <autocomplete-geography></autocomplete-geography>
        <label>@lang('html.search.status')</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="search_among" id="search_among_concerned" value="concerned" checked>
            <label class="form-check-label" for="search_among_concerned">
                @lang('html.search.among_concerned')
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="search_among" id="search_among_reported" value="reported">
            <label class="form-check-label" for="search_among_reported">
                @lang('html.search.among_reported')
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="search_among" id="search_among_all" value="all">
            <label class="form-check-label" for="search_among_all">
                @lang('html.search.among_all')
            </label>
        </div>
        <button class="btn btn-primary mt-3">@lang('html.view-card.search.button')</button>
        {{ Form::close() }}
    </div>
@endsection
