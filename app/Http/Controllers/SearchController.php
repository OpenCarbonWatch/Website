<?php

namespace App\Http\Controllers;

use App\Model\Activity;
use App\Model\City;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{
    public function franceSearchDataActivity(string $query)
    {
        $activities = Activity::where('label_1', 'ILIKE', "%$query%")
            ->orWhere('label_2', 'ILIKE', "%$query%")
            ->orWhere('label_3', 'ILIKE', "%$query%")
            ->orWhere('label_4', 'ILIKE', "%$query%")
            ->orWhere('label_5', 'ILIKE', "%$query%")
            ->orWhere('id_1', 'ILIKE', "%$query%")
            ->orWhere('id_2', 'ILIKE', "%$query%")
            ->orWhere('id_3', 'ILIKE', "%$query%")
            ->orWhere('id_4', 'ILIKE', "%$query%")
            ->orWhere('id_5', 'ILIKE', "%$query%")
            ->orderBy('id_1')
            ->orderBy('id_2')
            ->orderBy('id_3')
            ->orderBy('id_4')
            ->orderBy('id_5')
            ->get();
        $previous = [1 => null, 2 => null, 3 => null, 4 => null, 5 => null];
        $results = [];
        foreach ($activities as $activity) {
            foreach ([1, 2, 3, 4, 5] as $level) {
                $label = $activity->getAttribute("id_$level") . ' ' . $activity->getAttribute("label_$level");
                if ($previous[$level] != $label) {
                    $previous[$level] = $label;
                    $results[] = ['label' => $label, 'level' => $level];
                }
            }
        }
        return Response::json($results);
    }

    public function franceSearchDataGeography(string $query)
    {
        $regions = City::select('region_name')->distinct()->where('region_name', 'ILIKE', "%$query%")->orderBy('region_name')->get();
        $departments = City::select('department_name')->distinct()->where('department_name', 'ILIKE', "%$query%")->orderBy('department_name')->get();
        $cities = City::where('city_name', 'ILIKE', "%$query%")->orderBy('city_name')->get();
        $regions = $regions->map(function ($region) {
            return ['id' => 'region-' . base64_encode($region->region_name), 'label' => $region->region_name, 'class' => 'region', 'badge' => trans('html.search.region')];
        });
        $departments = $departments->map(function ($department) {
            return ['id' => 'department-' . base64_encode($department->department_name), 'label' => $department->department_name, 'class' => 'department', 'badge' => trans('html.search.department')];
        });
        $cities = $cities->map(function ($city) {
            return ['id' => 'city-' . base64_encode($city->city_name), 'label' => $city->city_name, 'class' => 'city', 'badge' => $city->id];
        });
        $data = collect($regions)->merge($departments)->merge($cities);
        return Response::json($data);
    }
}
