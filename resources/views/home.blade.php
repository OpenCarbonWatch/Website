@extends('layouts.html')

@section('content')
    <div id="jumbo" class="row mb-3 px-0 py-0 ml-0 mr-0">
        <div class="col-md-9 px-4 py-4 mb-3 light">
            <p>@lang('html.carbon')</p>
            <p><b>@lang('html.description')</b></p>
        </div>
        <div class="col-md-3 px-4 py-4 mb-3 light d-none d-md-block">
            <img src="/img/logo.svg" class="jumbo-logo"/>
        </div>
    </div>
    <div class="mb-5">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">@lang('html.navbar.context')</h5>
                        <p class="card-text">@lang('html.caps.context')</p>
                        <a href="{{ route('texts-context') }}" class="btn btn-dark mt-auto">@lang('html.view-card.view')</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">@lang('html.navbar.what-we-do')</h5>
                        <p class="card-text">@lang('html.caps.what-we-do')</p>
                        <a href="{{ route('texts-what-we-do') }}" class="btn btn-dark mt-auto">@lang('html.view-card.view')</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                <div class="card bg-info h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">@lang('html.navbar.france')</h5>
                        <p class="card-text">@lang('html.caps.france')</p>
                        <a href="{{ route('france') }}" class="btn btn-dark mt-auto">@lang('html.view-card.explore')</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">@lang('html.navbar.how-to-help')</h5>
                        <p class="card-text">@lang('html.caps.how-to-help')</p>
                        <a href="{{ route('texts-how-to-help') }}" class="btn btn-dark mt-auto">@lang('html.view-card.view')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5">
        @markdownFile('jumbo.other')
    </div>
@endsection
