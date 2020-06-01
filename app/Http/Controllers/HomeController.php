<?php

namespace App\Http\Controllers;

use App\Model\Organization;
use App\Model\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function france()
    {
        return view('france');
    }

    public function franceSearch()
    {
        return view('france-search');
    }

    public function franceBuildSearchObject(Request $request)
    {
        $payload = [];
        $name = $request->input('name');
        if ($name && strlen($name) > 0) {
            $payload['organization_name'] = "%$name%";
        }
        $geography = $request->input('geography');
        if ($geography && strlen($geography) >= 1) {
            $payload['geography_name'] = $geography;
        }
        $activity = $request->input('activity');
        if ($activity && strlen($activity) >= 1) {
            $activity = explode(' ', $activity)[0];
            $payload['activity_id'] = $activity;
        }
        $payload['search_among'] = $request->input('search_among');
        $payload = json_encode($payload);
        $search = Search::where('payload', $payload)->first();
        if ($search === null) {
            $search = new Search();
            $search->version = '1.0';
            $search->payload = $payload;
            $search->created_count = 1;
            $search->viewed_count = 0;
            $search->hashid = '';
            $search->save();
            $search->hashid = Hashids::encode($search->id);
            $search->save();
        } else {
            $search->created_count += 1;
            $search->save();
        }
        return redirect(route('france-search-results', ['search' => $search->hashid]));
    }

    public function franceViewSearchResults(Search $search)
    {
        $search->viewed_count += 1;
        $search->save();
        $payload = json_decode($search->payload, true);
        $query = Organization::select('organizations.*')->limit(5000);
        if (array_key_exists('organization_name', $payload)) {
            $query = $query->where('name', 'ILIKE', $payload['organization_name']);
        }
        if (array_key_exists('geography_name', $payload)) {
            $geography = $payload['geography_name'];
            $query = $query->join('cities', 'cities.id', '=', 'organizations.city_id')->where(function ($query) use ($geography) {
                $query->where('city_name', '=', $geography)
                    ->orWhere('department_name', '=', $geography)
                    ->orWhere('region_name', '=', $geography);
            });
        }
        if (array_key_exists('activity_id', $payload)) {
            $activity = $payload['activity_id'];
            $query = $query->join('activities', 'activities.id_5', '=', 'organizations.activity_id')->where(function ($query) use ($activity) {
                $query->where('id_1', '=', $activity)
                    ->orWhere('id_2', '=', $activity)
                    ->orWhere('id_3', '=', $activity)
                    ->orWhere('id_4', '=', $activity)
                    ->orWhere('id_5', '=', $activity);
            });
        }
        if ($payload['search_among'] == 'concerned') {
            $query = $query->whereNotNull('regulation');
        }
        if ($payload['search_among'] == 'reported') {
            $query = $query->whereHas('assessments');
        }
        return $this->showResults('html.search.results.title', $query);
    }

    public function franceRegionsDepartments()
    {
        // Keep "departments", "regions" and "other territorial collectivities" (e.g. Corsica), but exclude Paris and
        // Lyon, which we decide to report as cities, despite the fact that they are officially considered as "other
        // territorial collectivities".
        $query = Organization::whereIn('legal_type_id', ['7220', '7229', '7230'])
            ->whereNotIn('id', ['200046977', '217500016']);
        return $this->organizations('regions-departments', $query);
    }

    public function franceCities()
    {
        // Keep "cities" and include Paris, which we decide to report as a city, despite the fact that it is officially
        // considered as an "other territorial collectivity".
        $query = Organization::where(function ($query) {
            return $query->where('legal_type_id', '7210')
                ->orWhere('id', '217500016');
        });
        return $this->organizations('cities', $query);
    }

    public function franceCityGroups()
    {
        // Keep only the four city group types for which reporting is mandatory: "communautés de communes",
        // "communautés d'agglomérations", "communautés urbaines" and "métropoles" and add "Métropole de Lyon", we
        // which decide to report as a city group despite the fact that it is an "other territorial collectivity".
        $query = Organization::where(function ($query) {
            return $query->whereIn('legal_type_id', ['7343', '7344', '7346', '7348'])
                ->orWhere('id', '200046977');
        });
        return $this->organizations('city-groups', $query);
    }

    public function franceState()
    {
        $query = Organization::where('legal_type_id', 'LIKE', '71%');
        return $this->organizations('state', $query);
    }

    public function franceOtherPublic()
    {
        $query = Organization::where('regulation', '5');
        return $this->organizations('other-public', $query);
    }

    public function franceCompanies()
    {
        $query = Organization::where(function ($query) {
            $query->where('legal_type_id', 'LIKE', '3%')
                ->orWhere('legal_type_id', 'LIKE', '5%')
                ->orWhere('legal_type_id', 'LIKE', '6%');
        });
        return $this->organizations('companies', $query);
    }

    public function franceSpecializedPrivate()
    {
        $query = Organization::where('legal_type_id', 'LIKE', '8%');
        return $this->organizations('specialized-private', $query);
    }

    public function franceAssociations()
    {
        $query = Organization::where('legal_type_id', 'LIKE', '9%');
        return $this->organizations('associations', $query);
    }

    private function organizations($key, Builder $query)
    {
        $title = "html.view-card.$key.title";
        return $this->showResults($title, $query->whereNotNull('regulation'));
    }

    private function showResults($title, Builder $query)
    {
        $organizations = $query
            ->with(['assessments', 'legalType', 'city'])
            ->orderBy('name')
            ->get()->all();
        $results = [];
        $stats = ['danger' => 0, 'warning' => 0, 'success' => 0, 'light' => 0, 'total' => 0];
        foreach ($organizations as $organization) {
            $year = null;
            foreach ($organization->assessments as $a) {
                if ($a->hasEmissions12() && ($year == null || $a->reporting_year > $year)) {
                    $year = $a->reporting_year;
                }
            }
            $reductions = false;
            $scope3 = false;
            foreach ($organization->assessments as $a) {
                if ($year == $a->reporting_year && $a->hasEmissions12()) {
                    $reductions = $reductions || $a->hasReductions();
                    $scope3 = $scope3 || ($a->total_scope_3 > 0.0);
                }
            }
            $status = 'light';
            if ($organization->regulation != null) {
                if ($year == null) {
                    $status = 'danger';
                } else {
                    $thisYear = Carbon::now()->year - 1;
                    $legalYear = ($organization->regulation == 1 || $organization->regulation == 2) ? $thisYear - 4 : $thisYear - 3;
                    $status = ($year < $legalYear) ? 'danger' : (($year == $legalYear) ? 'warning' : 'success');
                }
            }
            $stats[$status] = $stats[$status] + 1;
            $stats['total'] = $stats['total'] + 1;
            $shortLabel = $organization->name;
            $longLabel = $organization->name;
            if (strlen($shortLabel) > 62) {
                $shortLabel = substr($shortLabel, 0, 58) . ' ...';
            }
            if ($organization->city) {
                $longLabel .= ' [' . $organization->city->department_name . ', ' . $organization->city->city_name . ']';
            }
            $result = compact('organization', 'status', 'shortLabel', 'longLabel', 'year', 'scope3', 'reductions');
            $results[] = $result;
        }
        $results = $this->disambiguateLabelsUsingDepartments($results);
        return view('results', compact('title', 'results', 'stats'));
    }

    private function disambiguateLabelsUsingDepartments($results)
    {
        $duplicated = [];
        $lastLabel = '';
        foreach ($results as $result) {
            if ($result['shortLabel'] === $lastLabel) {
                $duplicated[$lastLabel] = true;
            }
            $lastLabel = $result['shortLabel'];
        }
        for ($i = 0; $i < count($results); $i++) {
            if (array_key_exists($results[$i]['shortLabel'], $duplicated)) {
                $city = $results[$i]['organization']->city;
                if ($city) {
                    $department = substr($city->id, 0, 3);
                    if (substr($department, 0, 2) !== '97') {
                        $department = substr($department, 0, 2);
                    }
                    $results[$i]['shortLabel'] .= ' [' . $department . ']';
                }
            }
        }
        return $results;
    }

    public function franceOrganization($id)
    {
        $organization = Organization::with('legalType')->find($id);
        $assessments = $organization->assessments()->with('organizations')->orderBy('reporting_year', 'DESC')->get();
        $alerts = [
            'split_year' => count(array_unique($assessments->map(function($a) { return $a->reporting_year; })->all())) < count($assessments),
            'shared_report' => !$assessments->every(function($a) { return count($a->organizations) == 1; }),
            'nested' => $organization->population == null,
        ];
        return view('organizations.show', compact('alerts', 'assessments', 'organization'));
    }
}
