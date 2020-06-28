@extends('layouts.html')

@section('title', trans($title) . ' - France')

@section('content')
    <div class="mb-5">
        <h2>@lang($title) ({{ count($results) }})</h2>
        @if (count($results) > 0)
            <div class="progress mt-3 mb-3" style="height: 1.5rem;">
                <div class="progress-bar bg-danger" role="progressbar"
                     style="width:{{ 100 * $stats['danger'] / $stats['total'] }}%">
                    {{ $stats['danger'] }}
                </div>
                <div class="progress-bar bg-warning" role="progressbar"
                     style="width:{{ 100 * $stats['warning'] / $stats['total'] }}%">
                    {{ $stats['warning'] }}
                </div>
                <div class="progress-bar bg-success" role="progressbar"
                     style="width:{{ 100 * $stats['success'] / $stats['total'] }}%">
                    {{ $stats['success'] }}
                </div>
                <div class="progress-bar bg-light" role="progressbar"
                     style="width:{{ 100 * $stats['light'] / $stats['total'] }}%">
                    {{ $stats['light'] }}
                </div>
            </div>
            @if (count($results) >= 5000)
                <div class="alert alert-warning">
                    @lang('html.search.results.overload')
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-sm text-nowrap">
                    <thead>
                    <tr>
                        <th>@lang('results.th.name')</th>
                        <th class="text-center">@lang('results.th.last_year')</th>
                        <th class="text-center">@lang('results.th.reductions')</th>
                        <th class="text-center">@lang('results.th.scope3')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td title="{{ $result['longLabel'] }}">
                                <!-- For CSS purifier: badge-danger badge-warning badge-success badge-light -->
                                <span class="badge badge-pill badge-{{ $result['status'] }} mr-1">&nbsp;</span>
                                <a href="{{ route('france-organization', ['id' => $result['organization']->id]) }}">{{ $result['shortLabel'] }}</a>
                            </td>
                            <td class="text-center">
                                {{ $result['year'] ?? '' }}
                            </td>
                            <td class="text-center">
                                @if ($result['year'] != null)
                                    {{ $result['reductions'] ? trans('results.yes') : trans('results.no') }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($result['year'] != null)
                                    {{ $result['scope3'] ? trans('results.yes') : trans('results.no') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p><i>@lang('results.disclaimer')</i></p>
        @else
            <div class="alert alert-warning">
                @lang('html.search.results.none')
            </div>
        @endif
    </div>
@endsection
