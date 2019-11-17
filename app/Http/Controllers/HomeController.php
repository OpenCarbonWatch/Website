<?php

namespace App\Http\Controllers;

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

    public function franceRegionsDepartments()
    {
        $title = 'html.view-card.regions-departments.title';
        $results = [];
        return view('results', compact('title', 'results'));
    }
}
