@extends('layouts.html')

@section('content')
    <div class="mb-5">
        <h2>{{ $organization->name }}</h2>
        <h3>@lang('results.identity-card.title')</h3>
        <ul>
            <li><b>@lang('results.identity-card.id')</b> {{ $organization->id }}</li>
            @if ($organization->city)
                <li>
                    <b>@lang('results.identity-card.city')</b>
                    {{ $organization->city->region_name }} / {{ $organization->city->department_name }}
                    / {{ $organization->city->city_name }} ({{ $organization->city->id }})
                </li>
            @endif
            @if ($organization->max_staff == null)
                <li><b>@lang('results.identity-card.staff')</b>
                    @lang('results.identity-card.staff_sentence_unbounded', ['min'=>  $organization->min_staff ])
                </li>
            @else
                <li><b>@lang('results.identity-card.staff')</b>
                    @lang('results.identity-card.staff_sentence_bounded', ['min'=> $organization->min_staff, 'max' => $organization->max_staff ])
                </li>
            @endif
            @if ($organization->population > 0)
                <li><b>@lang('results.identity-card.population')</b> {{ $organization->population }}</li>
            @endif
            <li><b>@lang('results.identity-card.regulation')</b> @lang('results.regulation' . $organization->regulation ?? '0')</li>
        </ul>
        <h3>@lang('results.reports')</h3>
        <div class="table-responsive mb-3">
            <table class="table table-sm text-nowrap">
                <thead>
                <tr>
                    <th>@lang('results.th.year')</th>
                    <th>@lang('results.th.total_scope_1')</th>
                    <th>@lang('results.th.total_scope_2')</th>
                    <th>@lang('results.th.total_scope_3')</th>
                    <th>@lang('results.th.reductions')</th>
                    <th>@lang('results.th.link')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($assessments as $assessment)
                    <tr>
                        <td>
                            {{ $assessment->reporting_year }}
                            @if ($assessment->is_draft)
                                *
                            @endif
                        </td>
                        <td>{{ number_format($assessment->total_scope_1) }} tCO2e</td>
                        <td>{{ number_format($assessment->total_scope_2) }} tCO2e</td>
                        <td>
                            @if ($assessment->total_scope_3 > 0)
                                {{ number_format($assessment->total_scope_3) }} tCO2e
                            @else
                                <span class="badge badge-pill badge-light">@lang('results.missing')</span>
                            @endif
                        </td>
                        <td>
                            @if ($assessment->sumReductions() > 0)
                                - {{ number_format($assessment->sumReductions()) }} tCO2e
                            @else
                                <span class="badge badge-pill badge-light">@lang('results.none')</span>
                            @endif
                        </td>
                        <td><a href="{{ $assessment->source_url }}">@lang('results.view')</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @foreach (['split_year', 'shared_report', 'nested', 'is_draft'] as $alert)
            @if ($alerts[$alert])
                <div class="alert alert-info">
                    @lang("results.alerts.$alert")
                </div>
            @endif
        @endforeach
        <h3>@lang('results.identity-card.classification')</h3>
        <ul>
            @if ($organization->legalType)
                <li>
                    <b>@lang('results.identity-card.legal_type')</b>
                    <ul>
                        <li>{{ $organization->legalType->id_1 }} - {{ $organization->legalType->label_1 }}</li>
                        <li>{{ $organization->legalType->id_2 }} - {{ $organization->legalType->label_2 }}</li>
                        <li>{{ $organization->legalType->id_3 }} - {{ $organization->legalType->label_3 }}</li>
                    </ul>
                </li>
            @endif
            @if ($organization->activity)
                <li>
                    <b>@lang('results.identity-card.activity')</b>
                    <ul>
                        <li>{{ $organization->activity->id_1 }} - {{ $organization->activity->label_1 }}</li>
                        <li>{{ $organization->activity->id_2 }} - {{ $organization->activity->label_2 }}</li>
                        <li>{{ $organization->activity->id_3 }} - {{ $organization->activity->label_3 }}</li>
                        <li>{{ $organization->activity->id_4 }} - {{ $organization->activity->label_4 }}</li>
                        <li>{{ $organization->activity->id_5 }} - {{ $organization->activity->label_5 }}</li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
@endsection
