@extends('layouts.html')

@section('content')
    <div id="jumbo" class="row mb-5 px-0 py-0 ml-0 mr-0">
        <div class="col-md-9 px-4 py-4 mb-3 light">
            <p>@lang('html.carbon')</p>
            <p><b>@lang('html.description')</b></p>
        </div>
        <div class="col-md-3 px-4 py-4 mb-3 light d-none d-md-block">
            <img src="/img/logo.svg" class="jumbo-logo"/>
        </div>
    </div>
    <div class="mb-5">
        <h2>@lang('html.jumbo.h2')</h2>
        <h3>@lang('html.jumbo.france-title')</h3>
        @markdownFile('jumbo.france')
        <a href="{{ route('france') }}" class="btn btn-primary mb-3">@lang('html.jumbo.france-button')</a>
        @markdownFile('jumbo.other')
    </div>
@endsection
