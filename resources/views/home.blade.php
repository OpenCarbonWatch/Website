@extends('layouts.html')

@section('content')
    <h1>Open Carbon Watch</h1>
    <div id="jumbo" class="row mb-5 px-0 py-0 ml-0 mr-0">
        <div class="col-md-5 px-4 py-4 mb-3 dark">
            @lang('html.description')
        </div>
        <div class="col-md-7 px-4 py-4 mb-3 light">
            @lang('html.want-to-help')
        </div>
    </div>
    <div class="mb-5">
        <h2>@lang('html.jumbo.h2')</h2>
        <h3>@lang('html.jumbo.france-title')</h3>
        @markdownFile('jumbo.france')
        <a href="{{ route('france') }}" class="btn btn-light mb-3">@lang('html.jumbo.france-button')</a>
        @markdownFile('jumbo.other')
    </div>
    <div class="mb-5">
        @markdownFile('faq')
    </div>
@endsection
