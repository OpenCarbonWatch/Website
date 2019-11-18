@extends('layouts.html')

@section('content')
    <h1>Open Carbon Watch</h1>
    @include('layouts.navbar')
    <div class="mb-5">
        <h2>@lang($title) ({{ count($results) }})</h2>
        <div class="progress mt-3 mb-3">
            <div class="progress-bar bg-danger" role="progressbar" style="width:{{ 100 * $stats['danger'] / $stats['total'] }}%">
                {{ $stats['danger'] }}
            </div>
            <div class="progress-bar bg-warning" role="progressbar" style="width:{{ 100 * $stats['warning'] / $stats['total'] }}%">
                {{ $stats['warning'] }}
            </div>
            <div class="progress-bar bg-success" role="progressbar" style="width:{{ 100 * $stats['success'] / $stats['total'] }}%">
                {{ $stats['success'] }}
            </div>
            <div class="progress-bar bg-light" role="progressbar" style="width:{{ 100 * $stats['light'] / $stats['total'] }}%">
                {{ $stats['light'] }}
            </div>
        </div>
        <p><i>@lang('results.disclaimer')</i></p>
        <div class="table-responsive">
            <table class="table table-sm text-nowrap">
                <thead>
                <tr>
                    <th>@lang('results.th.name')</th>
                    <th>@lang('results.th.city')</th>
                    <th>@lang('results.th.last_year')</th>
                    <th>@lang('results.th.reductions')</th>
                    <th>@lang('results.th.scope3')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td title="{{ $result['organization']->name }}">
                            <a href="{{ route('france-organization', ['id' => $result['organization']->id]) }}">
                            @if (strlen($result['organization']->name) > 70)
                                {{ substr($result['organization']->name, 0, 60) . ' ...' }}
                            @else
                                {{ $result['organization']->name }}
                            @endif
                            </a>
                        </td>
                        <td>
                            {{ $result['organization']->city_id }}
                        </td>
                        <td>
                            <!-- For CSS purifier: badge-danger badge-warning badge-success badge-light -->
                            <span class="badge badge-pill badge-{{ $result['status'] }}">
                                {{ $result['year'] ?? trans('results.none') }}
                            </span>
                        </td>
                        <td>
                            @if ($result['year'] != null)
                                {{ $result['reductions'] ? trans('results.yes') : trans('results.no') }}
                            @endif
                        </td>
                        <td>
                            @if ($result['year'] != null)
                                {{ $result['scope3'] ? trans('results.yes') : trans('results.no') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
