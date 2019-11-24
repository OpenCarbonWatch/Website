<?php

namespace App\Http\Controllers;

use App\Model\Organization;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function franceSearchResults(Request $request)
    {
        $name = $request->get('name');
        $name = strtoupper($name);
        $query = Organization::where('name', 'LIKE', '%' . $name . '%')->limit(5000);
        if ($request->get('search_among') == 'concerned') {
            $query = $query->whereNotNull('regulation');
        }
        if ($request->get('search_among') == 'reported') {
            $query = $query->whereHas('assessments');
        }
        return $this->showResults('html.search.results.title', $query);
    }

    public function franceRegionsDepartments()
    {
        $query = Organization::whereIn('organization_type_id', ['7220', '7229', '7230']);
        return $this->organizations('regions-departments', $query);
    }

    public function franceCities()
    {
        $query = Organization::whereIn('organization_type_id', ['7210']);
        return $this->organizations('cities', $query);
    }

    public function franceCityGroups()
    {
        $query = Organization::whereIn('organization_type_id', ['7343', '7344', '7346', '7348']);
        return $this->organizations('city-groups', $query);
    }

    public function franceState()
    {
        $query = Organization::where('organization_type_id', 'LIKE', '71%');
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
            $query->where('organization_type_id', 'LIKE', '3%')
                ->orWhere('organization_type_id', 'LIKE', '5%')
                ->orWhere('organization_type_id', 'LIKE', '6%');
        });
        return $this->organizations('companies', $query);
    }

    public function franceSpecializedPrivate()
    {
        $query = Organization::where('organization_type_id', 'LIKE', '8%');
        return $this->organizations('specialized-private', $query);
    }

    public function franceAssociations()
    {
        $query = Organization::where('organization_type_id', 'LIKE', '9%');
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
            ->with(['assessments', 'organizationType'])
            ->orderBy('name')
            ->get()->all();
        $results = [];
        $stats = ['danger' => 0, 'warning' => 0, 'success' => 0, 'light' => 0, 'total' => 0];
        foreach ($organizations as $organization) {
            $year = null;
            foreach ($organization->assessments as $a) {
                if ($a->hasEmissions12()) {
                    if ($year == null || $a->reporting_year > $year) {
                        $year = $a->reporting_year;
                    }
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
            $result = compact('organization', 'status', 'year', 'scope3', 'reductions');
            $results[] = $result;
        }
        return view('results', compact('title', 'results', 'stats'));
    }

    public function franceOrganization($id)
    {
        $organization = Organization::with('organizationType')->find($id);
        $assessments = $organization->assessments()->with('organizations')->orderBy('reporting_year', 'DESC')->get();
        $alerts = [
            'split_year' => count(array_unique($assessments->map(function($a) { return $a->reporting_year; })->all())) < count($assessments),
            'shared_report' => !$assessments->every(function($a) { return count($a->organizations) == 1; }),
            'nested' => $organization->population == null,
        ];
        return view('organizations.show', compact('alerts', 'assessments', 'organization'));
    }
}
